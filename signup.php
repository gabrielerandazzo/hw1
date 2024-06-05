<?php
require_once 'dbconfig.php';

$response = array('status' => '', 'message' => '', 'error_code' => 0);

if (!empty($_POST["surname"]) && !empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && strlen($_POST["password"]) >= 8) {
    $error = array();
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error[] = "Email non valida";
        $response['error_code'] = 5;
    } else {
        $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));

        $mailCheckUrl = "https://api.mailcheck.ai/email/" . $email;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $mailCheckUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($curl), true);

        if ($response['disposable'] == false) {
            $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Email già in uso";
                $response['error_code'] = 6;
            }
        } else {

            $error[] = "Non puoi usare un email temporanea";
            $response['error_code'] = 6;
        }
    }


    if (count($error) == 0) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $surname = mysqli_real_escape_string($conn, $_POST['surname']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $password = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users(name, surname, email, password) VALUES('$name', '$surname', '$email','$password')";

        if (mysqli_query($conn, $query)) {
            session_start();
            $_SESSION["name"] = $_POST["name"];
            $_SESSION["user_id"] = mysqli_insert_id($conn);
            $response['status'] = 'success';
            $response['message'] = 'ok';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = implode(", ", $error);
    }

    mysqli_close($conn);
} else {
    $error = "";
    if (empty($_POST["name"])) {
        $error = 'Il nome non può essere vuoto!';
        $response['error_code'] = 1;
    }

    if (empty($_POST["surname"])) {
        $error = 'Il cognome non può essere vuoto!';
        $response['error_code'] = 2;
    }

    if (empty($_POST["email"])) {
        $error = 'Inserisci un email valida';
        $response['error_code'] = 3;
    }

    if (empty($_POST["password"]) || strlen($_POST["password"]) < 8) {
        $error = 'La password deve essere >= a 8 caratteri!';
        $response['error_code'] = 4;
    }

    if ($error != "") {
        $response['message'] = $error;
    }
}

echo json_encode($response);
?>