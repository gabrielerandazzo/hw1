<?php
require_once 'auth.php';

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
$response = array('status' => 'error', 'message' => 'Errore generico', 'error_code' => 0, 'total_price' => 0);
$cartId = null;
$userId = checkAuth();

if (!empty($_POST['product_id']) && !empty($_POST['amount'])) {
    $productId = mysqli_real_escape_string($conn, $_POST['product_id']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $datetime = date('Y-m-d H:i:s');

    if (!$userId) {
        if (!isset($_SESSION['cart_id'])) {
            $query = "INSERT INTO cart (created) VALUES ('$datetime')";
            if (mysqli_query($conn, $query)) {
                $cartId = mysqli_insert_id($conn);
                $_SESSION["cart_id"] = $cartId;
            } else {
                $response['message'] = 'Errore durante la creazione del carrello: ' . mysqli_error($conn);
                echo json_encode($response);
                mysqli_close($conn);
                exit;
            }
        } else {
            $cartId = $_SESSION["cart_id"];
        }
    } else {
        $checkCartQuery = "SELECT id FROM cart WHERE user_id = '$userId'";
        $result = mysqli_query($conn, $checkCartQuery);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $cartId = $row['id'];
            $_SESSION['cart_id'] = $cartId;
        } else {
            $insertCartQuery = "INSERT INTO cart (user_id, created) VALUES ('$userId', '$datetime')";
            if (mysqli_query($conn, $insertCartQuery)) {
                $cartId = mysqli_insert_id($conn);
                $_SESSION["cart_id"] = $cartId;
            } else {
                $response['message'] = 'Errore durante la creazione del carrello: ' . mysqli_error($conn);
                echo json_encode($response);
                mysqli_close($conn);
                exit;
            }
        }
    }

    $checkProductQuery = "SELECT id, amount FROM cart_products WHERE cart_id = '$cartId' AND product_id = '$productId'";
    $result = mysqli_query($conn, $checkProductQuery);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $newAmount = $row['amount'] + $amount;
        $rowId = $row['id'];
        $updateProductQuery = "UPDATE cart_products SET amount = '$newAmount' WHERE id='$rowId'";
        if (mysqli_query($conn, $updateProductQuery)) {
            $response['status'] = 'success';
            $response['message'] = "";
        } else {
            $response['message'] = 'Impossibile aggiornare il prodotto: ' . mysqli_error($conn);
        }
    } else {
        $insertProductQuery = "INSERT INTO cart_products(cart_id, product_id, amount) VALUES('$cartId', '$productId', '$amount')";
        if (mysqli_query($conn, $insertProductQuery)) {
            $response['status'] = 'success';
            $response['message'] = "";
        } else {
            $response['message'] = 'Impossibile inserire il prodotto: ' . mysqli_error($conn);
        }
    }

    echo json_encode($response);
} else {
    $response['message'] = 'Id prodotto e quantita assenti';
    echo json_encode($response);
}
mysqli_close($conn);
?>