<?php
require_once 'auth.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['cart_id'])) {
    if (
        !empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['way']) &&
        !empty($_POST['way-number']) && !empty($_POST['cap']) && !empty($_POST['city']) &&
        !empty($_POST['country']) && !empty($_POST['phone-code']) && !empty($_POST['phone-number'])
    ) {
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

        $cart_id = mysqli_real_escape_string($conn, $_SESSION['cart_id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $surname = mysqli_real_escape_string($conn, $_POST['surname']);

        if (isset($_POST['business-address'])) {
            $business_address = 1;
        } else {
            $business_address = 0;
        }
        $way = mysqli_real_escape_string($conn, $_POST['way']);
        $way_number = mysqli_real_escape_string($conn, $_POST['way-number']);
        $cap = mysqli_real_escape_string($conn, $_POST['cap']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $country = mysqli_real_escape_string($conn, $_POST['country']);
        $phone_code = mysqli_real_escape_string($conn, $_POST['phone-code']);
        $phone_number = mysqli_real_escape_string($conn, $_POST['phone-number']);

        if (!empty($_POST['cf'])) {
            $cf = mysqli_real_escape_string($conn, $_POST['cf']);
        } else {
            $cf = "NULL";
        }

        $saveAddressQuery = "INSERT INTO address (cart_id, name, surname, business_address, cf, way, way_number, cap, city, country, 
        phone_area_code, phone_number) VALUES ('$cart_id', '$name', '$surname', '$business_address', '$cf', '$way', '$way_number', '$cap', 
        '$city', '$country', '$phone_code', '$phone_number')";

        if (mysqli_query($conn, $saveAddressQuery)) {

            $_SESSION['address_id'] = mysqli_insert_id($conn);
            header("Location: payments.php");
        } else {
            $error = "Errore durante l'inserimento dei dati";
        }

        mysqli_close($conn);
    } else {
        $error = "Compila i campi obbligatori";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
    <link rel="stylesheet" href="address.css">
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
                    <div class="step-number current">3</div>
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

    <section class="address">
        <h1 class="title">Fornisca il Suo indirizzo di consegna e fatturazione</h1>
        <form method="post">
            <div class="name-surname-container">
                <div class="input-container">
                    <label for="name">Nome *</label>
                    <input type="text" id="name" name="name" value="">
                </div>
                <div class="input-container">
                    <label for="surname">Cognome *</label>
                    <input type="text" id="surname" name="surname" value="">
                </div>
            </div>

            <div class="business-address">
                <input type="checkbox" id="business-address" name="business-address" value="1">
                <label for="business-address"> È un indirizzo aziendale</label>
            </div>

            <div class="input-container cf-container">
                <label for="cf"> Codice fiscale (opzionale)</label>
                <input type="text" id="cf" name="cf" value="">
            </div>

            <div class="way-container">
                <div class="input-container via">
                    <label for="way">Via *</label>
                    <input type="text" name="way" id="way" value="">
                </div>
                <div class="input-container numero-civico">
                    <label for="way-number">Numero civico *</label>
                    <input type="text" name="way-number" id="way-number" value="">
                </div>
            </div>

            <a class="additional-address" href="">
                <div class="additional-address-icon">+</div>
                Indirizzo aggiuntivo
            </a>

            <div class="country-info">
                <div class="input-container">
                    <label for="cap">Cap *</label>
                    <input type="text" name="cap" id="cap" value="">
                </div>
                <div class="input-container">
                    <label for="city">Città *</label>
                    <input type="text" name="city" id="city" value="">
                </div>
                <div class="input-container">
                    <label for="country">Paese *</label>
                    <input type="text" name="country" id="country" value="">
                </div>
            </div>

            <div class="phone-container">
                <label for="phone">Tel *</label>
                <div class="phone-inputs">
                    <select id="phone-code" name="phone-code">
                        <option value="IT">IT +39</option>
                    </select>
                    <input type="text" id="phone-number" name="phone-number" value="">
                </div>
                <span>In modo da poterla contattare per avere informazioni sul Suo ordine</span>
            </div>

            <div class="shipping-billing-container">
                <input type="checkbox" name="shipping-billing-address" value="1">
                <label for="shipping-billing-address"> Gli indirizzi di consegna e fatturazione coincidono</label>
            </div>

            <div class="allow-contact">
                <input type="checkbox" name="allow-contact" value="1">
                <label for="allow-contact"> Sì, accetto che AUTODOC mi contatti telefonicamente o via SMS per informarmi
                    su prodotti e offerte speciali, a scopo di sondaggio e per la raccolta di dati statistici. Sono
                    consapevole del mio diritto di revocare tale consenso in qualsiasi momento.</label>
            </div>
            <label for="seguente"><?php echo $error; ?></label>
            <button type="submit" name="seguente">Seguente</button>
        </form>
    </section>

    <footer>
        <a href="">Note legali</a>
    </footer>
</body>

</html>