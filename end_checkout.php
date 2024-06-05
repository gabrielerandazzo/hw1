<?php
require_once 'auth.php';


if (isset($_SESSION['cart_id'])) {
    if ($userId = checkAuth()) {
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

        $removeCurrentCartQuery = "UPDATE cart SET user_id = NULL WHERE id =" . $_SESSION['cart_id'];

        mysqli_query($conn, $removeCurrentCartQuery);
        mysqli_close($conn);
    }
}

unset($_SESSION['total_price']);
unset($_SESSION['cart_id']);
unset($_SESSION['address_id']);
unset($_SESSION['last_confirmed_order']);

header("Location: index.php");
exit;
?>