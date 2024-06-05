<?php
require_once 'auth.php';
$userId = checkAuth();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
    <link rel="stylesheet" href="cart.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <script src="cart.js" defer></script>
</head>

<body>
    <header class="cart-header-container">
        <div class="cart-header">
            <a href="index.php" class="autodoc-logo">
                <img src="assets/logo-dark.svg" alt="">
            </a>
            <div class="header-steps">
                <div class="step">
                    <div class="step-number current">1</div>
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

    <section class="products">
        <div class="main-container">
            <div class="products-container">

                <button class="all-favorite-btn">
                    <svg>
                        <use xlink:href="assets/basket-sprite.svg#wishlist"></use>
                    </svg>
                    Aggiungere tutti gli articoli alla mia lista dei desideri
                </button>
            </div>

            <div class="order-container">
                <div class="title">Il tuo ordine:</div>
                <div class="order-prices">
                    <div class="order-prices-row">
                        <span>Prezzo totale della merce</span>
                        <span id="total-price-products"></span>
                    </div>
                </div>
                <div class="total-price">
                    <div class="order-prices-row">
                        <span>Totale dell'ordine</span>
                        <span id="total-price-order"></span>
                    </div>
                    <div class="order-prices-row">
                        <span></span>
                        <span class="order-vat-text">incl. IVA 22%</span>
                    </div>
                </div>
                <?php

                if (!$userId) {
                    $cartLoginUrl = "cart-login.php";
                    echo "<button class='order-btn' onclick='location.href=\"" . $cartLoginUrl . "\"'>
                        Procedere con l'ordine
                        </button>";
                } else {
                    $addresUrl = "address.php";
                    echo "<button class='order-btn' onclick='location.href=\"" . $addresUrl . "\"'>
                        Procedere con l'ordine
                        </button>";
                }
                ?>

                <span class="order-container-btn-separator">o completare il pagamento con (opzionale)</span>

                <button class="paypal-btn">
                    <img src="assets/paypal-logo-small.svg" alt="">
                    <img src="assets/paypal-logo-full.svg" alt="">
                    Paga adesso
                </button>
            </div>
        </div>
    </section>

    <section class="top-products">
        <div class="top-products-container">

        </div>
    </section>

    <div class="brand-image-container">
        <div class="brand-image-item">

        </div>
    </div>

    <footer>
        <a href="">Note legali</a>
    </footer>
</body>

</html>