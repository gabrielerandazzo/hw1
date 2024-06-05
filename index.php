<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autodoc</title>
    <link rel="stylesheet" href="index.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="index.js" defer></script>
</head>


<body>
    <div class="top-header">
        <a class="top-header-button-selected" href="">SHOP</a>
        <a class="top-header-button" href="">CLUB</a>
    </div>
    <header>
        <div class="header-container">
            <div id="riga1">
                <div id="header-plus-ads">
                    <span id="svg-plus-icon">
                        <svg id="plus-icon">
                            <use xlink:href="assets/icon-sprite-color.svg#sprite-plus-icon-color"></use>
                        </svg>
                    </span>
                    <div id="plus-ads-title-point"></div>
                    <div id="plus-ads-title">
                        Provi l'account premium
                    </div>
                </div>
                <span id="header-autodoc-image">
                    <img id="autodoc-logo" src="assets/autodoc-logo.svg" alt="">
                </span>

                <div class="header-right">
                    <div class="header-icon-text">
                        <svg id="header-garage-icon">
                            <use xlink:href="assets/icon-sprite-bw.svg#sprite-garage-icon-bw"></use>
                        </svg>
                        <span class="header-counter">0</span>
                        <div class="header-right-text-container">
                            <span class="header-right-text-top">Il mio garage</span>
                            <span class="header-right-text-bottom">Aggiungere un veicolo</span>
                        </div>

                    </div>
                    <div class="header-icon-text-separator"></div>

                    <?php
                    require_once 'auth.php';
                    if (!$userid = checkAuth()) {
                        echo "<div class='header-icon-text' id='header-login' onclick='showLoginModal()'>
                                <svg id='header-login-icon'>
                                    <use xlink:href='assets/icon-sprite-bw.svg#sprite-user-icon-bw'></use>
                                </svg>
                                <div class='header-right-text-container'>
                                    <span class='header-right-text-top' id='my-autodoc-label'>Il mio AUTODOC</span>
                                    <span class='header-right-text-bottom' id='header-login-text'>Effettuare laccesso</span>
                                </div>
                            </div>";
                    } else {
                        echo "<div class='header-icon-text' id='header-login' onclick='showMioAutodocMenu()'>
                                <svg id='header-login-icon'>
                                    <use xlink:href='assets/icon-sprite-bw.svg#sprite-user-icon-bw'></use>
                                </svg>
                                <div class='header-right-text-container'>
                                    <span class='header-right-text-top' id='my-autodoc-label'>Il mio AUTODOC</span>
                                    <span class='header-right-text-bottom' id='header-login-text'>Ciao {$_SESSION['name']}</span>
                                </div>
                            </div>";
                    }
                    ?>

                </div>
            </div>
            <div id="riga2">
                <div class="header-menu">
                    <svg id="burger-icon">
                        <use xlink:href="assets//icon-sprite-bw.svg#sprite-burger-icon-bw"></use>
                    </svg>
                </div>
                <form class="header-search" autocomplete="off">
                    <?php
                    if (!empty($_GET['keyword'])) {
                        echo '<input type="text" id="search-input" placeholder="Inserisca il numero del pezzo o il nome"
                                name="keyword" value="' . $_GET['keyword'] . '">
                                <div class="input-esempio">
                                    <span id="esempio-text">Esempio</span>
                                </div>
                                </input>';
                    } else {
                        echo '<input type="text" id="search-input" placeholder="Inserisca il numero del pezzo o il nome"
                                        name="keyword">
                                    <div class="input-esempio">
                                        <span id="esempio-text">Esempio</span>
                                    </div>
                                    </input>';
                    }
                    ?>

                    <button id="search-btn" type="submit">
                        <svg id="search-icon">
                            <use xlink:href="assets/icon-sprite-bw.svg#sprite-search-icon-bw"></use>
                        </svg>
                        <span id="search-text">RICERCA</span>
                    </button>
                </form>
                <div class="header-right" id="cart-info" onclick="location.href = 'cart.php'">
                    <div class=" header-icon-text" id="cart-info-icon-text">
                        <svg id="cart-icon">
                            <use xlink:href="assets/icon-sprite-bw.svg#sprite-basket-icon-bw"></use>
                        </svg>
                        <span class="header-counter" id="header-cart-counter">0</span>
                        <div class="header-right-text-container">
                            <span id="articoli-text" class="header-right-text-top">Articoli</span>
                            <span id="numero-articoli" class="header-right-text-bottom">
                                #<?php
                                if (isset($_SESSION['cart_id'])) {
                                    echo $_SESSION['cart_id'];
                                }
                                ?></span>
                        </div>
                        <span id="cart-total">0,00 €</span>
                    </div>
                    <div class="header-icon-text-separator" id="header-icon-text-separator-cart"></div>
                    <div class="header-cart-details"></div>
                </div>


            </div>
            <nav>
                <div class="nav-item">
                    <svg class="navbar-icon">
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-truck-empty-bw"></use>
                    </svg>
                    <a class="text-nav" href="">Ricambi per camion</a>
                </div>
                <div class="nav-item">
                    <svg class="navbar-icon">
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-moto-empty-bw"></use>
                    </svg>
                    <a class="text-nav" href="">Motocicletta</a>
                </div>
                <div class="nav-item">
                    <svg class="navbar-icon">
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-tyres-icon-bw"></use>
                    </svg>
                    <a class="text-nav" href="">Pneumatici</a>
                </div>
                <div class="nav-item">
                    <svg class="navbar-icon">
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-tools-icon-bw"></use>
                    </svg>
                    <a class="text-nav" href="">Attrezzi</a>
                </div>
                <div class="nav-item">
                    <svg class="navbar-icon">
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-misc-icon-bw"></use>
                    </svg>
                    <a class="text-nav" href="">Accessori auto</a>
                </div>
                <div class="nav-item">
                    <svg class="navbar-icon">
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-oil-icon-bw"></use>
                    </svg>
                    <a class="text-nav" href="">Olio motore</a>
                </div>
                <div class="nav-item">
                    <svg class="navbar-icon">
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-filters-icon-bw"></use>
                    </svg>
                    <a class="text-nav" href="">Filtro</a>
                </div>
                <div class="nav-item">
                    <svg class="navbar-icon">
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-brackes-icon-bw"></use>
                    </svg>
                    <a class="text-nav" href="">Freni</a>
                </div>
                <div class="nav-item">
                    <svg class="navbar-icon">
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-electrocar-bw"></use>
                    </svg>
                    <a class="text-nav" href="">E-Mobility</a>
                </div>
            </nav>
        </div>

    </header>


    <section class="section1">
        <div class="car-selector">

            <div class="select-car-model-box">

                <p class="select-car-model-box-title">Selezionare il modello di automobile per cercare ricambi auto</p>

                <div class="custom-select-container">
                    <div class="custom-select-display select-selected">
                        <div class="number-circle number-circle-selected" data-index="1">1</div>
                        <span id="brandText">Scegliere la marca</span>
                        <select id="brandSelect" data-index="1">
                            <option value="0">Scegliere la marca</option>
                        </select>
                        <div class="vertical-separator"></div>
                        <div class="down-arrow"></div>
                    </div>
                </div>

                <div class="custom-select-container">
                    <div class="custom-select-display">
                        <div class="number-circle" data-index="2">2</div>
                        <span id="modelText">Scegliere il modello</span>
                        <select id="modelSelect" data-index="2">
                            <option value="0">Scegliere il modello</option>
                        </select>
                        <div class="vertical-separator"></div>
                        <div class="down-arrow"></div>
                    </div>
                </div>

                <div class="custom-select-container">
                    <div class="custom-select-display">
                        <div class="number-circle" data-index="3">3</div>
                        <span id="versionText">Scegliere la versione</span>
                        <select id="versionSelect" data-index="3">
                            <option value="0">Scegliere la versione</option>
                        </select>
                        <div class="vertical-separator"></div>
                        <div class="down-arrow"></div>
                    </div>
                </div>
                <div class="search-car-model-btn">
                    <span>Ricerca</span>
                </div>
            </div>

            <div class="search-by-numbers-container">
                <p class="search-by-numbers-title">Secondo il numero di targa</p>
                <span id="search-by-numbers-label"></span>
                <div class="search-by-numbers">
                    <div class="search-by-numbers-form">
                        <div class="ue-plate-symbols">
                            <img id="ue-icon" src="assets/ue-icon.png" alt="">
                            <p class="plate-symbol">I</p>
                        </div>
                        <input id="search-by-numbers-input" type="text" placeholder="AB 123 CD">
                    </div>
                    <div class="search-car-model-btn" id="search-by-numbers-btn">
                        <span>Ricerca</span>
                    </div>
                </div>

                <a id="not-found-link" href="">LA SUA AUTO NON È PRESENTE NEL CATALOGO?</a>
            </div>

        </div>

        <div class="banner-image-container">

            <div class="shown-image">
                <div class="shown-image-btn selected" id="shown-image-btn-1"></div>
                <div class="shown-image-btn" id="shown-image-btn-2"></div>
                <div class="shown-image-btn" id="shown-image-btn-3"></div>
                <div class="shown-image-btn" id="shown-image-btn-4"></div>
            </div>

            <img class="banner-image" src="assets/banner1.jpeg" alt="">
        </div>
    </section>

    <section class="section2">
        <h1 class="section-title">AUTODOC CATALOGO RICAMBI AUTO: RICERCA RICAMBI PER TARGA</h1>
        <div class="parts-grid-container">


            <div class="parts-grid-item">
                <div class="parts-grid-item-image-container">
                    <img src="assets/tyre.png" alt="" class="parts-grid-item-image">
                    <div class="parts-grid-item-separator"></div>
                </div>
                <span class="parts-grid-item-title">Pneumatici</span>
            </div>

            <div class="parts-grid-item">
                <div class="parts-grid-item-image-container">
                    <img src="assets/disk-brake.png" alt="" class="parts-grid-item-image">
                    <div class="parts-grid-item-separator"></div>
                </div>
                <span class="parts-grid-item-title">Freni</span>
            </div>

            <div class="parts-grid-item">
                <div class="parts-grid-item-image-container">
                    <img src="assets/filters.png" alt="" class="parts-grid-item-image">
                    <div class="parts-grid-item-separator"></div>
                </div>
                <span class="parts-grid-item-title">Filtro</span>
            </div>

            <div class="parts-grid-item">
                <div class="parts-grid-item-image-container">
                    <img src="assets/shock-absorber.png" alt="" class="parts-grid-item-image">
                    <div class="parts-grid-item-separator"></div>
                </div>
                <span class="parts-grid-item-title">Ammortizzazione</span>
            </div>

            <div class="parts-grid-item">
                <div class="parts-grid-item-image-container">
                    <img src="assets/car-body.png" alt="" class="parts-grid-item-image">
                    <div class="parts-grid-item-separator"></div>
                </div>
                <span class="parts-grid-item-title">Carrozzeria</span>
            </div>

            <div class="parts-grid-item">
                <div class="parts-grid-item-image-container">
                    <img src="assets/engine.png" alt="" class="parts-grid-item-image">
                    <div class="parts-grid-item-separator"></div>
                </div>
                <span class="parts-grid-item-title">Motore</span>
            </div>

            <div class="parts-grid-item">
                <div class="parts-grid-item-image-container">
                    <img src="assets/oil.png" alt="" class="parts-grid-item-image">
                    <div class="parts-grid-item-separator"></div>
                </div>
                <span class="parts-grid-item-title">Oli e liquidi</span>
            </div>

            <div class="parts-grid-item">
                <div class="parts-grid-item-image-container">
                    <img src="assets/suspensions.png" alt="" class="parts-grid-item-image">
                    <div class="parts-grid-item-separator"></div>
                </div>
                <span class="parts-grid-item-title">Sospensione</span>
            </div>

            <div class="parts-grid-item">
                <div class="parts-grid-item-image-container">
                    <img src="assets/belt-chains-rollers.png" alt="" class="parts-grid-item-image">
                    <div class="parts-grid-item-separator"></div>
                </div>
                <span class="parts-grid-item-title">Cinghie, catene, rulli</span>
            </div>

            <div class="parts-grid-item">
                <div class="parts-grid-item-image-container">
                    <img src="assets/clutch.png" alt="" class="parts-grid-item-image">
                    <div class="parts-grid-item-separator"></div>
                </div>
                <span class="parts-grid-item-title">Frizione</span>
            </div>

            <div class="parts-grid-item">
                <div class="parts-grid-item-image-container">
                    <img src="assets/electrical-system.png" alt="" class="parts-grid-item-image">
                    <div class="parts-grid-item-separator"></div>
                </div>
                <span class="parts-grid-item-title">Impianto elettrico</span>
            </div>

            <div class="parts-grid-item">
                <div class="parts-grid-item-image-container">
                    <img src="assets/other.png" alt="" class="parts-grid-item-image">
                    <div class="parts-grid-item-separator"></div>
                </div>
                <span class="parts-grid-item-title">Altre categorie</span>
            </div>
        </div>

        <span class="more-things-btn">
            Di più ricambi auto
            <svg class="more-things-btn-icon">
                <use xlink:href="assets/icon-sprite-bw.svg#sprite-right-arrow-icon-bw"></use>
            </svg>
        </span>
    </section>

    <section class="section3">
        <h2 class="section-title">COMPRARE AUTORICAMBI PER LE CASE AUTOMOBILISTICHE PIÙ CONOSCIUTE</h2>

        <div class="brand-grid-container"></div>


        <span class="more-things-btn">
            Più produttore auto
            <svg class="more-things-btn-icon">
                <use xlink:href="assets/icon-sprite-bw.svg#sprite-right-arrow-icon-bw"></use>
            </svg>
        </span>
    </section>

    <section class="section4">
        <h2 class="section-title">ACQUISTARE ONLINE PEZZI DI RICAMBIO AUTO DEI PRODUTTORI PIÙ NOTI</h2>
        <div class="parts-brand-container">
            <div id="parts-brand-1" class="parts-brand-item" data-index="1">
                <img src="assets/bosch.png" alt="">
            </div>

            <div id="parts-brand-2" class="parts-brand-item" data-index="2">
                <img src="assets/hella.png" alt="">
            </div>

            <div id="parts-brand-3" class="parts-brand-item" data-index="3">
                <img src="assets/vemo.png" alt="">
            </div>

            <div id="parts-brand-4" class="parts-brand-item" data-index="4">
                <img src="assets/febi.png" alt="">
            </div>

            <div id="parts-brand-5" class="parts-brand-item" data-index="5">
                <img src="assets/sachs.png" alt="">
            </div>

            <div id="parts-brand-6" class="parts-brand-item" data-index="6">
                <img src="assets/beru.png" alt="">
            </div>

            <div id="parts-brand-7" class="parts-brand-item" data-index="7">
                <img src="assets/at.png" alt="">
            </div>

            <div id="parts-brand-8" class="parts-brand-item" data-index="8">
                <img src="assets/behr.png" alt="">
            </div>
        </div>

        <span class="more-text">
            Di più
            <span class="more-btn"></span>
        </span>
    </section>

    <section class="section5">
        <div class="app-box-container">
            <img class="app-box-main-image" src="assets/app-screenshot.png" alt="">
            <span class="app-box-title">L'acquisto di prodotti tramite l'app è sempre più conveniente rispetto al sito
                web</span>
            <div class="app-box-download">
                <div class="app-box-links">
                    <img src="assets/google-play-logo.png" alt="">
                    <img src="assets/app-store-logo.png" alt="">
                </div>
                <img class="app-box-qr" src="assets/qr-code.png" alt="">
            </div>
            <span class="scan-to-download-text">ESEGUIRE SCANSIONE PER SCARICARE L’APPLICAZIONE</span>
        </div>
    </section>

    <section class="section6">
        <div class="social-container">
            <div id="social-text-container" class="social-item">
                <div class="social-text-separator"></div>
                <div class="social-text-title">
                    Riparare l’auto non è mai stato così facile
                </div>
                <p class="social-text-content">
                    Dica di no ad istruzioni complicate e diagrammi confusi. Utilizzi i pratici e semplici tutorial di
                    AUTODOC per la riparazione della Sua auto
                </p>
            </div>
            <div class="social-item">
                <img src="assets/autodoc-club-logo.svg" alt="" class="social-item-svg">

                <img class="social-item-image" src="assets/club-big.jpg" alt="">
                <div class="social-item-title">Guide dettagliate e video tutorial gratuiti per le riparazioni auto fai
                    da te</div>
                <div class="social-item-separator"></div>

                <div class="social-item-link">
                    <span class="social-item-link-text">UNIRSI AL CLUB</span>
                    <svg class="social-item-svg-play">
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-arrow-link-bw"></use>
                    </svg>
                </div>
            </div>


            <div class="social-item">
                <img src="assets/youtube-logo.svg" alt="" class="social-item-svg">

                <img class="social-item-image" src="assets/youtube-big.jpg" alt="">
                <div class="social-item-title">Videolezioni dai nostri esperti – tutte le informazioni necessarie per la
                    riparazione dell’auto.</div>
                <div class="social-item-separator"></div>

                <div class="social-item-link">
                    <span class="social-item-link-text">ANDARE AL NOSTRO CANALE YOUTUBE</span>
                    <svg class="social-item-svg-play">
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-arrow-link-bw"></use>
                    </svg>
                </div>
            </div>


            <div class="social-item">
                <img src="assets/instagram-logo.svg" alt="" class="social-item-svg">

                <img class="social-item-image" src="assets/instagram-big.jpg" alt="">
                <div class="social-item-title">Segua le ultime tendenze e scopra aggiornamenti, consigli utili e post
                    dedicati alle auto.</div>
                <div class="social-item-separator"></div>

                <div class="social-item-link">
                    <span class="social-item-link-text">PER SAPERNE DI PIÙ SU INSTAGRAM </span>
                    <svg class="social-item-svg-play">
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-arrow-link-bw"></use>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer1">
            <div class="footer-links-container">
                <div class="footer-links" data-index="1">
                    <div class="footer-links-title" data-index="1">CONOSCERE AUTODOC</div>
                    <div class="footer-links-arrow"></div>
                    <a class="footer-links-item" data-index="1">A proposito di Autodoc</a>
                    <a class="footer-links-item" data-index="1">Note legali</a>
                    <a class="footer-links-item" data-index="1">Programma fedeltà</a>
                    <a class="footer-links-item" data-index="1">Stampa</a>
                    <a class="footer-links-item" data-index="1">AUTODOC APP</a>
                    <a class="footer-links-item" data-index="1">AUTODOC PLUS</a>
                </div>

                <div class="footer-links" data-index="2">
                    <div class="footer-links-title" data-index="2">AIUTO & ASSISTENZA</div>
                    <div class="footer-links-arrow" data-index="2"></div>
                    <a class="footer-links-item" data-index="2">Club AUTODOC</a>
                    <a class="footer-links-item" data-index="2">Blog</a>
                    <a class="footer-links-item" data-index="2">Manuali e tutorial video per riparazioni auto</a>
                    <a class="footer-links-item" data-index="2">CGV</a>
                    <a class="footer-links-item" data-index="2">Condizioni generali di contratto PLUS</a>
                    <a class="footer-links-item" data-index="2">Diritto di recesso</a>
                    <a class="footer-links-item" data-index="2">Informativa sulla privacy</a>
                    <a class="footer-links-item" data-index="2">Impostazioni dei cookie</a>
                    <a class="footer-links-item" data-index="2">Codice di condotta</a>
                </div>

                <div class="footer-links" data-index="3">
                    <div class="footer-links-title" data-index="3">SERVIZIO DI ASSISTENZA CLIENTI </div>
                    <div class="footer-links-arrow" data-index="3"></div>
                    <a class="footer-links-item" data-index="3">Centro assistenza</a>
                    <a class="footer-links-item" data-index="3">Pagamento</a>
                    <a class="footer-links-item" data-index="3">Spedizione</a>
                    <a class="footer-links-item" data-index="3">Contatti</a>
                    <a class="footer-links-item" data-index="3">Reso dei prodotti</a>
                    <a class="footer-links-item" data-index="3">Sostituzione </a>
                </div>

                <div class="footer-links" data-index="4">
                    <div class="footer-links-title" data-index="4">I PRODOTTI MIGLIORI</div>
                    <div class="footer-links-arrow" data-index="4"></div>
                    <a class="footer-links-item" data-index="4">Illuminazione</a>
                    <a class="footer-links-item" data-index="4">Ammortizzatori</a>
                    <a class="footer-links-item" data-index="4">Kit frizione</a>
                    <a class="footer-links-item" data-index="4">Braccetti</a>
                    <a class="footer-links-item" data-index="4">Cuscinetto ruota</a>
                    <a class="footer-links-item" data-index="4">Prodotti per la pulizia dell'auto</a>
                    <a class="footer-links-item" data-index="4">Acquistare per marca</a>
                    <a class="footer-links-item" data-index="4">Acquistare per modello</a>
                    <a class="footer-links-item" data-index="4">Ricercare per marche di auto</a>
                    <a class="footer-links-item" data-index="4">Ricercare per marche di ricambi</a>
                </div>
            </div>
        </div>


        <div class="footer2">
            <div class="footer2-container">
                <div class="footer2-title">Si iscriva e inizi a risparmiare oggi stesso!</div>
                <div class="footer2-input-container">
                    <input class="footer2-email-input" placeholder="Email" type="text">
                    <div class="footer2-iscriviti-btn">iscriviti</div>
                </div>

                <div class="footer2-recive-information-container">
                    <input class="footer2-recive-information-checkbox" type="checkbox">
                    <div class="footer2-recive-information-checkbox-text">Sì, desidero ricevere la newsletter
                        personalizzata di AUTODOC con informazioni su prodotti, sconti, offerte speciali, prom...
                        <a href="">Di più</a>
                    </div>
                </div>
                <div class="footer2-privacy-policy">
                    <span>Si prega di prendere visione della nostra</span>
                    <a href="">Informativa sulla privacy.</a>
                </div>
            </div>

        </div>

        <div class="footer3">
            <div class="footer3-icons-container">
                <img src="assets/paypal-footer.svg" alt="" class="footer3-icons-image">
                <img src="assets/sofort-footer.svg" alt="" class="footer3-icons-image">
                <img src="assets/visa-footer.svg" alt="" class="footer3-icons-image">
                <img src="assets/mastercard-footer.svg" alt="" class="footer3-icons-image">
                <img src="assets/postepay-footer.svg" alt="" class="footer3-icons-image">
                <img src="assets/bank_transfer_IT-footer.svg" alt="" class="footer3-icons-image">
                <img src="assets/carta_si-footer.svg" alt="" class="footer3-icons-image">
                <img src="assets/dhl-footer.svg" alt="" class="footer3-icons-image">
                <img src="assets/ups-footer.svg" alt="" class="footer3-icons-image">
                <img src="assets/gls-footer.svg" alt="" class="footer3-icons-image">
            </div>
        </div>

        <div class="footer4">
            <div class="footer4-item" id="footer4-item1">
                <img src="assets/tecaliance-footer.svg" alt="">
                <p>I dati qui visualizzati, in particolare tutta la banca dati, non possono essere copiati. Sono
                    inoltre vietate, senza previa autorizzazione da parte di TecDoc, la duplicazione, diffusione e/o la
                    cessione e l’utilizzo da parte di terzi dei dati o di tutta la banca dati. La trasgressione di
                    queste regole costituisce una violazione del diritto di autore e sarà perseguita legalmente.</p>
            </div>
            <div class="footer4-container">
                <div class="footer4-item">
                    <span>Orari di lavoro del servizio di assistenza clienti per Italia</span>
                    <p>Dal Lunedi al Venerdi 08:00 - 20:00 <br>
                        Sabato 08:00 - 17:00 <br>
                        Domenica chiuso</p>

                    <div class="footer4-item-social">
                        <img src="assets/youtube-outline-grey.svg" alt="">
                        <img src="assets/facebook-outline.svg" alt="">
                        <img src="assets/instagram-outline.svg" alt="">
                    </div>
                </div>

                <div class="footer4-item">
                    <span>Servizio Clienti Internazionale</span>
                    <div class="custom-select">
                        <div class="custom-select-left">
                            <div>
                                <img src="assets/IT-footer.svg" alt="">
                                <span>
                                    Italia
                                </span>
                            </div>
                        </div>
                        <div class="custom-select-right">
                            <div class="vertical-separator"></div>
                            <div class="down-arrow"></div>

                        </div>

                    </div>
                    <p id="copyright-text">© 2024 www.auto-doc.it: AUTODOC negozio online</p>
                </div>
            </div>

        </div>
    </footer>

    <div class="fixed-chat-button">
        <img src="assets/chat-icon.png" alt="">
    </div>

    <section class="signup-modal-container show-none">
        <div class="close-signup-modal-btn">X</div>
        <div class="modal" id="signup-modal">
            <div class="modal-title">CREARE UN NUOVO ACCOUNT</div>
            <form id="signup-form" autocomplete="off">
                <input type="text" id="signup-name" placeholder="Nome">
                <span id="nameLabel"></span>
                <input type="text" id="signup-surname" placeholder="Cognome">
                <span id="surnameLabel"></span>
                <input type="email" id="signup-email" placeholder="Email">
                <span id="emailLabel"></span>

                <input type="password" id="signup-password" placeholder="Password">
                <span id="passwordLabel"></span>
                <span>Si prega di prendere visione della nostra Informativa sulla privacy.</span>
                <div class="signup-privacy">
                    <input type="checkbox">
                    <span>Sì, desidero ricevere la newsletter personalizzata di AUTODOC con informazioni su prodotti,
                        sconti, offerte speciali, prom... Di più</span>
                </div>
                <input type="submit" value="Registrati" id="signup-btn">
            </form>
        </div>
    </section>

    <section class="login-modal-container show-none">
        <div class="close-login-modal-btn">X</div>
        <div class="modal" id="login-modal">
            <div class="modal-title">ACCEDI</div>
            <form id="login-form">
                <input type="email" id="login-email" placeholder="Email" value="">
                <input type="password" id="login-password" placeholder="Password" value="">
                <span id="login-message-label"></span>
                <div class="save-access">
                    <input type="checkbox">
                    <span>Salvare</span>
                </div>
                <input type="submit" value="Accedi" id="login-btn">
            </form>

            <div class="create-account-btn">Se non si dispone ancora di un account AUTODOC,<span>REGISTRARSI
                    ADESSO.</span></div>
        </div>
    </section>

    <div class="mio-autodoc-menu-container show-none">
        <div id="empty-space"></div>
        <div id="mio-autodoc-menu">
            <div id="empty-space"></div>
            <div class="mio-autodoc-menu-item" id="autodoc-plus" data-index="1">
                <svg>
                    <use xlink:href="assets/icon-sprite-color.svg#sprite-autodoc-plus-color"></use>
                </svg>
                <span>AUTODOC PLUS</span>
                <div class="right-arrow mio-autodoc-arrow-position"></div>
            </div>

            <div class="mio-autodoc-menu-item" data-index="2">
                <svg>
                    <use xlink:href="assets/icon-sprite-bw.svg#sprite-garage-filled-icon-bw"></use>
                </svg>
                <span>I miei veicoli</span>
                <div class="right-arrow mio-autodoc-arrow-position"></div>
            </div>

            <div class="mio-autodoc-menu-item" data-index="3">
                <svg>
                    <use xlink:href="assets/icon-sprite-bw.svg#sprite-history-bw"></use>
                </svg>
                <span>I miei ordini</span>
                <div class="right-arrow mio-autodoc-arrow-position"></div>
            </div>

            <div class="mio-autodoc-menu-item" data-index="4">
                <svg>
                    <use xlink:href="assets/icon-sprite-bw.svg#sprite-youtube-fill-bw"></use>
                </svg>
                <span>AUTODOC CLUB</span>
                <div class="right-arrow mio-autodoc-arrow-position"></div>
            </div>

            <div class="mio-autodoc-menu-item" data-index="5">
                <svg>
                    <use xlink:href="assets/icon-sprite-bw.svg#sprite-location-icon-bw"></use>
                </svg>
                <span>I miei indirizzi</span>
                <div class="right-arrow mio-autodoc-arrow-position"></div>
            </div>

            <div class="mio-autodoc-menu-item" data-index="6">
                <svg>
                    <use xlink:href="assets/icon-sprite-bw.svg#sprite-wallet-icon-bw"></use>
                </svg>
                <span>Coordinate bancarie</span>
                <div class="right-arrow mio-autodoc-arrow-position"></div>
            </div>

            <div class="mio-autodoc-menu-item" data-index="7">
                <svg>
                    <use xlink:href="assets/icon-sprite-bw.svg#sprite-mail-icon-bw"></use>
                </svg>
                <span>Impostazioni</span>
                <div class="right-arrow mio-autodoc-arrow-position"></div>
            </div>

            <div class="mio-autodoc-menu-item" data-index="8">
                <svg>
                    <use xlink:href="assets/icon-sprite-bw.svg#sprite-payment-icon-bw"></use>
                </svg>
                <span>Il mio conto di deposito</span>
                <div class="right-arrow mio-autodoc-arrow-position"></div>
            </div>

            <div class="mio-autodoc-menu-item" data-index="9">
                <svg>
                    <use xlink:href="assets/icon-sprite-bw.svg#sprite-heart-filled-icon-bw"></use>
                </svg>
                <span>La mia lista dei desideri</span>
                <div class="right-arrow mio-autodoc-arrow-position"></div>
            </div>

            <div class="mio-autodoc-menu-item" data-index="10">
                <span>Esci</span>
            </div>
        </div>
    </div>

    <div class="main-menu-container show-none">
        <div class="main-menu">
            <?php
            require_once 'auth.php';
            if (!$userid = checkAuth()) {
                echo "
                    <div class='main-menu-element' onclick='showLoginModal()'>
                    <div class='main-menu-icon-text'>
                                <svg class='main-menu-icon'>
                                    <use xlink:href='assets/icon-sprite-bw.svg#sprite-user-icon-bw'></use>
                                </svg>
                                <div class='header-right-text-container'>
                                    <span class='main-menu-text' id='my-autodoc-label'>Il mio AUTODOC</span>
                                    <span class='main-menu-text-subtitle' id='header-login-text'>Effettuare laccesso</span>
                                </div>
                            </div>
                            <div class='right-arrow'></div>
                        </div>
                        ";
            } else {
                echo "
                    <div class='main-menu-element' onclick='showMioAutodocMainMenu()'>
                    <div class='main-menu-icon-text'>
                                <svg class='main-menu-icon'>
                                    <use xlink:href='assets/icon-sprite-bw.svg#sprite-user-icon-bw'></use>
                                </svg>
                                <div class='header-right-text-container'>
                                    <span class='main-menu-text' id='my-autodoc-label'>Il mio AUTODOC</span>
                                    <span class='main-menu-text-subtitle' id='header-login-text'>Ciao {$_SESSION['name']}</span>
                                </div>
                            </div>
                            <div class='right-arrow'></div>
                        </div>
                        ";
            }
            ?>

            <div class="main-menu-element">
                <div class="main-menu-icon-text">
                    <svg class="main-menu-icon">
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-garage-icon-bw"></use>
                    </svg>
                    <span class="header-counter" id="header-counter-main-menu">0</span>
                    <div class="header-right-text-container">
                        <span class="main-menu-text">Il mio garage</span>
                        <span class="main-menu-text-subtitle">Aggiungere un veicolo</span>
                    </div>
                </div>
                <div class="right-arrow"></div>
            </div>


            <div id="main-menu-mio-autodoc" class="show-none">
                <div id="empty-space"></div>
                <div class="mio-autodoc-menu-item" id="autodoc-plus" data-index="1">
                    <svg>
                        <use xlink:href="assets/icon-sprite-color.svg#sprite-autodoc-plus-color"></use>
                    </svg>
                    <span>AUTODOC PLUS</span>
                    <div class="right-arrow"></div>
                </div>

                <div class="mio-autodoc-menu-item" data-index="2">
                    <svg>
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-garage-filled-icon-bw"></use>
                    </svg>
                    <span>I miei veicoli</span>
                    <div class="right-arrow"></div>
                </div>

                <div class="mio-autodoc-menu-item" data-index="3">
                    <svg>
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-history-bw"></use>
                    </svg>
                    <span>I miei ordini</span>
                    <div class="right-arrow"></div>
                </div>

                <div class="mio-autodoc-menu-item" data-index="4">
                    <svg>
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-youtube-fill-bw"></use>
                    </svg>
                    <span>AUTODOC CLUB</span>
                    <div class="right-arrow"></div>
                </div>

                <div class="mio-autodoc-menu-item" data-index="5">
                    <svg>
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-location-icon-bw"></use>
                    </svg>
                    <span>I miei indirizzi</span>
                    <div class="right-arrow"></div>
                </div>

                <div class="mio-autodoc-menu-item" data-index="6">
                    <svg>
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-wallet-icon-bw"></use>
                    </svg>
                    <span>Coordinate bancarie</span>
                    <div class="right-arrow"></div>
                </div>

                <div class="mio-autodoc-menu-item" data-index="7">
                    <svg>
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-mail-icon-bw"></use>
                    </svg>
                    <span>Impostazioni</span>
                    <div class="right-arrow"></div>
                </div>

                <div class="mio-autodoc-menu-item" data-index="8">
                    <svg>
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-payment-icon-bw"></use>
                    </svg>
                    <span>Il mio conto di deposito</span>
                    <div class="right-arrow"></div>
                </div>

                <div class="mio-autodoc-menu-item" data-index="9">
                    <svg>
                        <use xlink:href="assets/icon-sprite-bw.svg#sprite-heart-filled-icon-bw"></use>
                    </svg>
                    <span>La mia lista dei desideri</span>
                    <div class="right-arrow"></div>
                </div>

                <div class="mio-autodoc-menu-item" data-index="10">
                    <span>Esci</span>
                </div>
            </div>
        </div>
        <div class="main-menu-container-spacer">ciao</div>
    </div>

</body>

</html>