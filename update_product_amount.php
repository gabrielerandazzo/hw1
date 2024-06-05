<?php
require_once 'dbconfig.php';

session_start();

$cartId = $_SESSION["cart_id"];
$response = array('status' => 'error', 'message' => 'cart id:' . $cartId . ' product id:' . $_POST['product_id'] . ' amount:' . $_POST['amount'], 'error_code' => 0);

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

if (!empty($_POST['product_id']) && isset($_POST['amount'])) {
    if ($cartId) {
        $amount = $_POST['amount'];
        $productId = $_POST['product_id'];
        if ($amount == 0) {
            $removeProductQuery = "DELETE FROM cart_products WHERE product_id = '$productId' AND cart_id = '$cartId'";
            $result = mysqli_query($conn, $removeProductQuery);

            if ($result) {
                $response["status"] = "success";
                $response["message"] = "Prodotto eliminato dal carrello";
            } else {
                $response["message"] = "Errore durante l'eliminazione del prodotto";
            }
        } else {
            $updateProductQuery = "UPDATE cart_products SET amount = '$amount' WHERE product_id = '$productId' AND cart_id = '$cartId'";
            $result = mysqli_query($conn, $updateProductQuery);

            if ($result) {
                $response["status"] = "success";
                $response["message"] = "Prodotto aggiornato nel carrello";
            } else {
                $response["message"] = "Errore durante la modifica del prodotto";
            }
        }
    }
}
mysqli_close($conn);
echo json_encode($response);
?>