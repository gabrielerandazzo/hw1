<?php
require_once 'dbconfig.php';

$response = array('status' => '', 'message' => '', 'error_code' => 0);
session_start();

if (!empty($_POST["email"]) && !empty($_POST["password"])) {
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $query = "SELECT * FROM users WHERE email = '" . $email . "'";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    if (mysqli_num_rows($res) > 0) {
        $entry = mysqli_fetch_assoc($res);
        $userId = $entry['id'];

        if (password_verify($_POST['password'], $entry['password'])) {

            if (isset($_SESSION['cart_id'])) {

                $cartId = $_SESSION['cart_id'];
                $assocCartQuery = "UPDATE cart SET user_id = '$userId' WHERE id = '$cartId'";

                $result = mysqli_query($conn, $assocCartQuery);
                $response['message'] = 'cart id:' . $cartId;
            } else {
                $response['message'] = session_status();
            }


            $_SESSION['cart_id'] = $cartId;
            $_SESSION["name"] = $entry['name'];
            $_SESSION["user_id"] = $userId;

            mysqli_close($conn);

            $response['status'] = 'success';

            echo json_encode($response);
            exit;
        }
    }
    $error = "Email e/o password errati";
    $response['status'] = 'error';
} else {

    $response['status'] = 'error';

    if (empty($_POST["email"])) {
        $error = "Inserisci un email valida";
        $response['error_code'] = 1;
    }

    if (empty($_POST["password"])) {
        $error = "Inserisci un password valida";
        $response['error_code'] = 2;
    }
}

if (strlen($error) > 0) {
    $response['message'] = $error;
}

echo json_encode($response);
?>