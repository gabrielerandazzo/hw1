<?php
include 'auth.php';

$error = '';

if (!empty($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'login') {
        if (!empty($_POST["email"]) && !empty($_POST["password"])) {
            $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $query = "SELECT * FROM users WHERE email = '$email'";

            $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

            if (mysqli_num_rows($res) > 0) {
                $entry = mysqli_fetch_assoc($res);
                $userId = $entry['id'];

                if (password_verify($_POST['password'], $entry['password'])) {
                    if (isset($_SESSION['cart_id'])) {
                        $cartId = $_SESSION['cart_id'];
                        $assocCartQuery = "UPDATE cart SET user_id = '$userId' WHERE id = '$cartId'";
                        mysqli_query($conn, $assocCartQuery);
                    } else {
                        echo "error";
                        mysqli_close($conn);
                        exit;
                    }

                    $_SESSION['cart_id'] = $cartId;
                    $_SESSION["name"] = $entry['name'];
                    $_SESSION["user_id"] = $userId;

                    mysqli_close($conn);
                    header("Location: address.php");
                    exit;
                }
            }
            mysqli_close($conn);
            $error = "Email e/o password errati";
        }

    } elseif ($action == 'signup') {
        if (!empty($_POST["surname"]) && !empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && strlen($_POST["password"]) >= 8) {
            $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "Email non valida";
            } else {
                $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
                $mailCheckUrl = "https://api.mailcheck.ai/email/" . $email;

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $mailCheckUrl);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $response = json_decode(curl_exec($curl), true);
                curl_close($curl);

                if ($response['disposable'] == false) {
                    $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
                    if (mysqli_num_rows($res) > 0) {
                        $error = "Email già in uso";
                        mysqli_close($conn);
                    } else {
                        $name = mysqli_real_escape_string($conn, $_POST['name']);
                        $surname = mysqli_real_escape_string($conn, $_POST['surname']);
                        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                        $query = "INSERT INTO users (name, surname, email, password) VALUES ('$name', '$surname', '$email', '$password')";
                        if (mysqli_query($conn, $query)) {
                            $userId = mysqli_insert_id($conn);

                            if (isset($_SESSION['cart_id'])) {
                                $cartId = $_SESSION['cart_id'];
                                $assocCartQuery = "UPDATE cart SET user_id = '$userId' WHERE id = '$cartId'";
                                mysqli_query($conn, $assocCartQuery);
                            } else {
                                echo "error";
                                mysqli_close($conn);
                                exit;
                            }

                            $_SESSION["name"] = $name;
                            $_SESSION["user_id"] = $userId;
                            mysqli_close($conn);
                            header("Location: address.php");
                            exit;
                        } else {
                            $error = "Errore nella registrazione";
                        }
                    }
                } else {
                    $error = "Non puoi usare un'email temporanea";
                }
                mysqli_close($conn);
            }
        } else {
            $error = "Compila tutti i campi";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
    <link rel="stylesheet" href="cart-login.css">

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
                    <div class="step-number current">2</div>
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


    <section class="signup-login">
        <div class="main-container">


            <div class="form-container">
                <form id="login-form" method="post">
                    <div class="form-title">Clienti attuali</div>
                    <input type="email" id="login-email" name="email" placeholder="Email" value="">
                    <input type="password" id="login-password" name="password" placeholder="Password" value="">
                    <span id="login-message-label"><?php echo $error; ?></span>
                    <a href="" class="forgot-password">Avete dimenticato la password?</a>
                    <input type="hidden" name="action" value="login">
                    <input type="submit" value="Accedi" id="login-btn">
                </form>

                <form id="signup-form" method="post" autocomplete="off">
                    <div class="form-title">Si registri</div>
                    <input type="text" id="signup-name" name="name" placeholder="Nome" value="">
                    <input type="text" id="signup-surname" name="surname" placeholder="Cognome" value="">
                    <input type="email" id="signup-email" name="email" placeholder="Email" value="">
                    <input type="password" id="signup-password" name="password" placeholder="Password" value="">
                    <span id="passwordLabel"><?php echo $error; ?></span>
                    <span>Si prega di prendere visione della nostra Informativa sulla privacy.</span>
                    <div class="signup-privacy">
                        <input type="checkbox" name="privacy">
                        <span>Sì, desidero ricevere la newsletter personalizzata di AUTODOC con informazioni su
                            prodotti, sconti, offerte speciali, prom... Di più</span>
                    </div>
                    <input type="hidden" name="action" value="signup">
                    <input type="submit" value="Registrati" id="signup-btn">
                </form>
            </div>
            <div action="" id="without-signup">
                <div class="form-title">Pagamento da ospite</div>
                <span>È possibile effettuare un ordine senza doversi registrare.</span>
                <a id="signup-btn" href="address.php">Seguente</a>
            </div>
        </div>
    </section>



    <footer>
        <a href="">Note legali</a>
    </footer>
</body>

</html>