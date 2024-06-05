<?php
require_once 'dbconfig.php';

session_start();

$response = array('status' => 'error', 'message' => 'Errore generico', 'error_code' => 0, 'products' => array(), 'total_price' => 0, 'total_amount' => 0);
$cartId = $_SESSION["cart_id"];

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

if ($cartId) {
    $cartDetailsQuery = "
    SELECT p.id, p.name, p.short_desc, p.image_path, p.brand_image_path, p.details, p.category, p.product_number, p.price, p.quantity, p.rating, cp.amount, (p.price * cp.amount) AS total_price
    FROM cart_products cp
    JOIN products p ON cp.product_id = p.id
    WHERE cp.cart_id = '$cartId'
";
    $res = mysqli_query($conn, $cartDetailsQuery);
    $products = array();
    $totalPrice = 0;
    $totalAmount = 0;
    while ($row = mysqli_fetch_assoc($res)) {
        $products[] = $row;
        $totalPrice += $row['total_price'];

        $totalAmount += $row['amount'];
    }

    $totalPrice = number_format($totalPrice, 2);

    $_SESSION['total_price'] = $totalPrice;

    $response['status'] = 'success';
    $response['message'] = '';
    $response['products'] = $products;
    $response['total_price'] = $totalPrice;
    $response['total_amount'] = $totalAmount;
} else {
    $response['status'] = 'error';
    $response['message'] = 'Il carrello non esiste';
}

mysqli_close($conn);
echo json_encode($response);
?>