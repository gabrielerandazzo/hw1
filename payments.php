<?php
require_once 'dbconfig.php';
session_start();

if (!isset($_SESSION['cart_id']) && !isset($_SESSION['address_id'])) {
    header("Location: address.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['payment_method'])) {
        $paymentMethod = $_POST['payment_method'];

        switch ($paymentMethod) {
            case 'paypal':
                break;
            case 'bonifico':
                break;
            case 'carta':
                header("Location: credit_card.php");
                break;
            default:
                echo "Metodo di pagamento non valido.";
                break;
        }
    } else {
        echo "Nessun metodo di pagamento selezionato.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
    <link rel="stylesheet" href="payments.css">
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

    <section class="payment-methods">
        <h1>Si prega di scegliere il metodo di pagamento più conveniente.</h1>

        <form method="POST">
            <div class="payment-option">
                <div></div>
                <input type="radio" id="paypal" name="payment_method" value="paypal">
                <label for="paypal">
                    <img src="assets/paypal-logo-small.svg" alt="">
                    <img src="assets/paypal-logo-full.svg" alt="">
                    PayPal
                </label>
                <p>Per completare il pagamento, sarete reindirizzati alla pagina sicura di PayPal</p>
            </div>
            <div class="payment-option">
                <input type="radio" id="bonifico" name="payment_method" value="bonifico">
                <label for="bonifico">
                    <img src="assets/bonifico.svg" alt="Bonifico Bancario"> Bonifico bancario
                </label>
            </div>
            <div class="payment-option">
                <input type="radio" id="carta" name="payment_method" value="carta">
                <label for="carta">
                    <img src="assets/visa.svg" alt="">
                    <img src="assets/mastercard.svg" alt="">
                    <img src="assets/american_express.svg" alt="">
                    <img src="assets/carta_si.svg" alt="">
                    <img src="assets/postepay.svg" alt="">
                    Carta di credito (raccomandato)
                </label>
            </div>
            <button type="submit">Seguente</button>
        </form>
    </section>

    <footer>
        <a href="">Note legali</a>
    </footer>
</body>

</html>