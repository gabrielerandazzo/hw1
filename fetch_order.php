<?php
require_once 'dbconfig.php';

session_start();

$response = array(
    'status' => 'error',
    'message' => 'Errore generico',
    'error_code' => 0,
    'total_price' => 0,
    'products' => array(),
    'address_data' => array(),
    'receipt_url' => ""
);

if (isset($_SESSION['last_confirmed_order'])) {
    $last_confirmed_order = $_SESSION['last_confirmed_order'];

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    if (!$conn) {
        $response['message'] = "Errore di connessione al database";
        mysqli_close($conn);
        echo json_encode($response);
        exit;
    }

    if ($last_confirmed_order) {
        $getIdsQuery = "SELECT cart_id, address_id, receipt_url FROM orders WHERE id='{$last_confirmed_order}'";
        $res = mysqli_query($conn, $getIdsQuery);

        if ($res) {
            $row = mysqli_fetch_assoc($res);
            if ($row) {
                $cartId = $row['cart_id'];
                $addressId = $row['address_id'];
                $receiptUrl = $row['receipt_url'];

                $removeCartUserQuery = "UPDATE cart SET user_id = null WHERE id = '{$cartId}'";
                $result = mysqli_query($conn, $removeCartUserQuery);

                if (!$result) {
                    $response['message'] = "Errore durante la rimozione del carrello";
                    mysqli_close($conn);
                    echo json_encode($response);
                    exit;
                }

                $fetchProductQuery = "SELECT p.id, p.name, p.short_desc, p.image_path, p.brand_image_path, p.product_number, p.price, cp.amount, (p.price * cp.amount) AS total_price
                FROM cart_products cp
                JOIN products p ON cp.product_id = p.id
                WHERE cp.cart_id = '$cartId'";

                $result = mysqli_query($conn, $fetchProductQuery);
                if ($result) {
                    $products = array();
                    $totalPrice = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $products[] = $row;
                        $totalPrice += $row['total_price'];
                    }

                    $totalPrice = number_format($totalPrice, 2);
                    $response['total_price'] = $totalPrice;
                    $response['products'] = $products;

                    $fetchAddressQuery = "SELECT name as 'Nome', surname as 'Cognome', business_address as 'Indirizzo aziendale'
                    , cf as 'Codice fiscale', way as 'Via', way_number as 'Numero civico', cap as 'Cap', city as 'Città',
                    country as 'Paese', phone_area_code as 'Prefisso telefonico', phone_number as 'Numero di telefono' FROM address WHERE id = '$addressId'";
                    $result = mysqli_query($conn, $fetchAddressQuery);

                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        if ($row) {
                            $addressData = array();
                            $addressData[] = $row;
                            $response['address_data'] = $addressData;
                            $response['status'] = 'success';
                            $response['message'] = 'Ordine trovato';
                            $response['receipt_url'] = $receiptUrl;
                        } else {
                            $response['message'] = "Indirizzo non trovato";
                        }
                    } else {
                        $response['message'] = "Errore durante il recupero dell'indirizzo";
                    }
                } else {
                    $response['message'] = "Errore durante il recupero dei prodotti";
                }
            } else {
                $response['message'] = "Ordine non trovato";
            }
        } else {
            $response['message'] = "Errore durante il recupero dell'ordine";
        }
    } else {
        $response['message'] = "Nessun ordine confermato trovato";
    }

    mysqli_close($conn);
} else {
    $response['message'] = "Sessione non valida";
}

echo json_encode($response);
?>