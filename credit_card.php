<?php
require_once 'auth.php';

session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['total_price']) && isset($_SESSION["cart_id"]) && isset($_SESSION['address_id'])) {

    $totalPrice = $_SESSION['total_price'];

    $secret_key = '';
    $token = 'tok_visa';
    $curlStripe = curl_init();

    curl_setopt($curlStripe, CURLOPT_URL, 'https://api.stripe.com/v1/charges');
    curl_setopt($curlStripe, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlStripe, CURLOPT_POST, 1);

    $paymentData = array(
        'amount' => $totalPrice * 100,
        'currency' => 'eur',
        'source' => $token,
        'description' => 'Acquisto ricambi'
    );

    $paymentDataString = http_build_query($paymentData);
    curl_setopt($curlStripe, CURLOPT_POSTFIELDS, $paymentDataString);

    curl_setopt(
        $curlStripe,
        CURLOPT_HTTPHEADER,
        array(
            'Authorization: Bearer ' . $secret_key,
            'Content-Type: application/x-www-form-urlencoded',
        )
    );

    $response = curl_exec($curlStripe);

    $responseData = json_decode($response, true);

    $receiptUrl = $responseData['receipt_url'];
    curl_close($curlStripe);

    if (isset($responseData['error'])) {
        echo 'Errore: ' . $responseData['error']['message'];

    } else {
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

        $userId = checkAuth();
        $placeOrderQuery = "";


        $cartId = $_SESSION["cart_id"];
        $addressId = $_SESSION['address_id'];

        if ($userId) {
            $placeOrderQuery = "INSERT INTO orders(user_id, cart_id, address_id, receipt_url) VALUES('$userId', '$cartId', '$addressId', '$receiptUrl')";
        } else {
            $placeOrderQuery = "INSERT INTO orders(cart_id, address_id, receipt_url) VALUES('$cartId', '$addressId', '$receiptUrl')";
        }

        if (mysqli_query($conn, $placeOrderQuery)) {
            echo "mysqli_error: " . mysqli_error($conn);
            $_SESSION['last_confirmed_order'] = mysqli_insert_id($conn);
            mysqli_close($conn);
            header("Location: confirm.php");
            exit;
        } else {
            $error = "Errore riprova più tardi";
        }

        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
    <link rel="stylesheet" href="credit_card.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>
    <header class="cart-header-container">
        <div class="cart-header">
            <a href="index.php" class="autodoc-logo">
                <img src="assets/logo-dark.svg" alt="">
            </a>
            <div class="header-steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-text">Carrello</div>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-text">Effettuare l'accesso</div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-text">Indirizzo di consegna</div>
                </div>
                <div class="step">
                    <div class="step-number current">4</div>
                    <div class="step-text">Pagamento</div>
                </div>
                <div class="step">
                    <div class="step-number">5</div>
                    <div class="step-text">Confermare</div>
                </div>
            </div>
            <div class="header-security">
                <img src="assets/secure.svg" alt="">
                Collegamento protetto
            </div>
        </div>
    </header>

    <section class="credit-card">
        <form method="post" id="payment-form">
            <div class="input-container">
                <label for="card-number">Numero della Carta:</label>
                <input type="text" name="card-number" required><br>
            </div>

            <div class="input-container">
                <label for="card-exp-month">Mese di Scadenza (MM):</label>
                <input type="text" name="card-exp-month" required><br>
            </div>

            <div class="input-container">
                <label for="card-exp-year">Anno di Scadenza (YY):</label>
                <input type="text" name="card-exp-year" required><br>
            </div>
            <div class="input-container">
                <label for="card-cvc">CVC:</label>
                <input type="text" name="card-cvc" required><br>
            </div>
            <div class="error-label"><?php echo $error; ?></div>
            <button type="submit">Paga</button>
        </form>
    </section>


    <footer>
        <a href="">Note legali</a>
    </footer>
</body>

</html>