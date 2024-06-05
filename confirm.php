<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
    <link rel="stylesheet" href="confirm.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <script src="confirm.js" defer></script>
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
                    <div class="step-number">4</div>
                    <div class="step-text">Pagamento</div>
                </div>
                <div class="step">
                    <div class="step-number current">5</div>
                    <div class="step-text">Confermare</div>
                </div>
            </div>
            <div class="header-security">
                <img src="assets/secure.svg" alt="">
                Collegamento protetto
            </div>
        </div>
    </header>

    <section class="order-status">
        <h1>ordine confermato!</h1>

        <div class="products-container">

        </div>

        <div class="order-container">
            <div class="order-prices">
                <div class="table-row">
                    <span>Prezzo totale della merce</span>
                    <span id="total-price-products"></span>
                </div>
            </div>
            <div class="total-price">
                <div class="table-row">
                    <span>Totale dell'ordine</span>
                    <span id="total-price-order"></span>
                </div>
                <div class="table-row">
                    <span></span>
                    <span class="order-vat-text">incl. IVA 22%</span>
                </div>
            </div>

            <h1 class="title">Dettagli di fatturazione:</h1>

            <div class="address-container">

            </div>
        </div>

        <a class="receipt order-btn" href="">Ricevuta</a>
        <a class="home order-btn" href="end_checkout.php">Torna alla home</a>
    </section>

    <footer>
        <a href="">Note legali</a>
    </footer>
</body>

</html>