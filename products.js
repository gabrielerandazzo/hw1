const body = document.querySelector('body');

const signup_modal = document.querySelector('.signup-modal-container');
const login_modal = document.querySelector('.login-modal-container');

function showSignupModal(event) {
    signup_modal.classList.remove('show-none');
    if (!login_modal.classList.contains('show-none')) {
        login_modal.classList.add('show-none');
        body.classList.add('no-scroll');
    }
}

function showLoginModal(event) {
    login_modal.classList.remove('show-none');
    body.classList.add('no-scroll');
    console.log("show login");
}

function closeSignupModal(event) {
    if (!signup_modal.classList.contains('show-none')) {
        signup_modal.classList.add('show-none');
        body.classList.remove('no-scroll');
    }
}

function closeloginModal(event) {
    if (!login_modal.classList.contains('show-none')) {
        login_modal.classList.add('show-none');
        body.classList.remove('no-scroll');
    }
}

const create_account_btn = document.querySelector('.create-account-btn');

create_account_btn.addEventListener('click', showSignupModal);

const close_login_modal_btn = document.querySelector('.close-login-modal-btn');

close_login_modal_btn.addEventListener('click', closeloginModal);

const close_signup_modal_btn = document.querySelector('.close-signup-modal-btn');

close_signup_modal_btn.addEventListener('click', closeSignupModal);

const mioAutodocMenu = document.querySelector('.mio-autodoc-menu-container');

function mioAutodocMenuItemClick(event) {
    const item = event.currentTarget;

    switch (item.dataset.index) {
        case '10':
            window.location.href = "logout.php";
            break;
        default:
            console.log(item.dataset.index);
            break;
    }
}

function showMioAutodocMenu(event) {
    mioAutodocMenu.classList.remove('show-none');
    console.log(mioAutodocMenu.classList);
    const mioAutodocMenuItem = document.querySelectorAll('.mio-autodoc-menu-item');
    for (const item of mioAutodocMenuItem) {
        item.addEventListener('click', mioAutodocMenuItemClick)
    }
}

function hideMioAutodocMenu(event) {
    mioAutodocMenu.classList.add('show-none');
}

document.querySelector('#mio-autodoc-menu').addEventListener('mouseleave', hideMioAutodocMenu);


function onSignupJson(json) {
    let message = json.message;
    console.log("json message:" + message);
    if (json.status === 'success') {
        console.log("success");
        window.location.reload();
    } else {
        const nameLabel = document.querySelector('#nameLabel');
        const surnameLabel = document.querySelector('#surnameLabel');
        const emailLabel = document.querySelector('#emailLabel');
        const passwordLabel = document.querySelector('#passwordLabel');

        nameLabel.textContent = "";
        surnameLabel.textContent = "";
        emailLabel.textContent = "";
        passwordLabel.textContent = "";

        switch (json.error_code) {
            case 1:
                nameLabel.textContent = message
                break;
            case 2:
                surnameLabel.textContent = message
                break;
            case 3:
                emailLabel.textContent = message
                break;
            case 4:
                passwordLabel.textContent = message
                break;
            case 5:
                emailLabel.textContent = message
                break;
            case 6:
                emailLabel.textContent = message
                break;
            case 7:
                emailLabel.textContent = message;
                break;
            default:
                alert('Errore: ' + message);
                break;
        }
    }
    json.message = "";
}

function onSignupResponse(response) {
    return response.json();
}

const regName = document.querySelector('#signup-name');
const regSurname = document.querySelector('#signup-surname');
const regEmail = document.querySelector('#signup-email');
const regPassword = document.querySelector('#signup-password');

function register(event) {
    event.preventDefault();

    const signupFormData = new FormData();
    signupFormData.append("name", regName.value);
    signupFormData.append("surname", regSurname.value);
    signupFormData.append("email", regEmail.value);
    signupFormData.append("password", regPassword.value);

    fetch("signup.php", {
        method: 'POST',
        body: signupFormData
    }).then(onSignupResponse).then(onSignupJson);
}

document.querySelector('#signup-form').addEventListener('submit', register);

function onLoginJson(json) {
    const message = json.message;
    console.log("json message:" + message);
    if (json.status === 'success') {

        console.log("success");
        window.location.reload();

        document.querySelector('#login-message-label').textContent = message;
    } else {
        document.querySelector('#login-message-label').textContent = message;
    }
}

function onLoginResponse(response) {
    return response.json();
}

function login(event) {
    event.preventDefault();

    const logEmail = document.querySelector('#login-email');
    const logPassword = document.querySelector('#login-password');

    const loginFormData = new FormData();
    loginFormData.append("email", logEmail.value);
    loginFormData.append("password", logPassword.value);

    fetch("login.php", {
        method: 'POST',
        body: loginFormData
    }).then(onLoginResponse).then(onLoginJson);

}

document.querySelector('#login-form').addEventListener('submit', login);

const brandSelect = document.querySelector('#brandSelect');
const modelSelect = document.querySelector('#modelSelect');
const versionSelect = document.querySelector('#versionSelect');

function onBandJson(json) {
    console.log(json);

    if (json.data_type === 'brand') {

        for (const brand of json.data) {

            console.log(brand);
            const option = document.createElement('option');
            option.value = brand;
            option.text = brand;
            brandSelect.appendChild(option);
        }
    } else if (json.data_type === 'model') {

        for (const model of json.data) {

            console.log(model);
            const option = document.createElement('option');
            option.value = model;
            option.text = model;
            modelSelect.appendChild(option);
        }
    } else if (json.data_type === 'version') {

        for (const version of json.data) {
            console.log(version);
            const option = document.createElement('option');
            option.value = version.id;
            option.text = version.version;
            versionSelect.appendChild(option);
        }
    }

}

function onBrandResponse(response) {
    return response.json();
}


fetch("fetch_vehicles.php?request=brand", {
    method: 'GET'
}).then(onBrandResponse).then(onBandJson);

function onSelectClick(event) {
    const select = event.currentTarget;

    for (const select of allSelects) {
        select.parentElement.classList.remove('select-selected');
    }

    select.parentElement.classList.add('select-selected');

    const allNumberCircles = document.querySelectorAll('.number-circle');

    for (const numberCircle of allNumberCircles) {
        numberCircle.classList.remove('number-circle-selected');
        if (numberCircle.dataset.index === select.dataset.index) {
            numberCircle.classList.add('number-circle-selected');
        }
    }
}

function onSelectChanged(event) {
    const select = event.currentTarget;
    const selectedOption = select.options[select.selectedIndex];

    if (selectedOption) {
        const selectedText = selectedOption.text;
        select.previousElementSibling.textContent = selectedText;
        console.log("select value: " + select.value);

        if (select.dataset.index === "1") {
            modelSelect.innerHTML = '<option value="0" selected>Scegliere il modello</option>';
            document.querySelector('#modelText').textContent = "Scegliere il modello";

            versionSelect.innerHTML = '<option value="0">Scegliere la versione</option>';
            document.querySelector('#versionText').textContent = "Scegliere la versione";

            if (select.value !== "0") {
                fetch('fetch_vehicles.php?request=model&brand=' + brandSelect.value, {
                    method: 'GET'
                }).then(onBrandResponse).then(onBandJson);
            }
        } else if (select.dataset.index === "2") {
            versionSelect.innerHTML = '<option value="0">Scegliere la versione</option>';
            document.querySelector('#versionText').textContent = "Scegliere la versione";

            if (modelSelect.value !== "0") {
                fetch('fetch_vehicles.php?request=version&brand=' + brandSelect.value + '&model=' + modelSelect.value, {
                    method: 'GET'
                }).then(onBrandResponse).then(onBandJson);
            }
        }
    }
}


var allSelects = document.querySelectorAll('.custom-select-container select');

for (const select of allSelects) {
    select.addEventListener('click', onSelectClick);
}

for (const select of allSelects) {
    select.addEventListener('change', onSelectChanged);
}

var customSelectDisplays = document.querySelectorAll('.custom-select-display');
for (var i = 0; i < customSelectDisplays.length; i++) {
    customSelectDisplays[i].addEventListener('click', function (event) {
        var selectElement = this.querySelector('select');
        selectElement.focus();
        selectElement.click();
    });
}

let productCartLabelAll = null;

const productCartIncBtnAll = document.querySelectorAll('.inc-btn');
const productCartDecBtnAll = document.querySelectorAll('.dec-btn');

function decProduct(event) {
    const btn = event.currentTarget;

    const productId = btn.dataset.product_id;

    for (const p of productCartLabelAll) {

        if (p.dataset.product_id === productId) {
            let quantity = parseInt(p.textContent);

            if (quantity > 1) {
                p.textContent = quantity - 1;
            }

        }
    }
}

function incProduct(event) {
    const btn = event.currentTarget;

    const productId = btn.dataset.product_id;

    for (const p of productCartLabelAll) {
        if (p.dataset.product_id === productId) {
            let quantity = parseInt(p.textContent);

            if (quantity < 98) {
                p.textContent = quantity + 1;
            }
        }
    }
}

const mainMenuBtn = document.querySelector('.header-menu');
const mainMenu = document.querySelector('.main-menu-container');

function hideMainMenu(event) {
    mainMenu.classList.add('show-none');
    body.classList.remove('no-scroll');
}

function showMainMenu(event) {
    mainMenu.classList.remove('show-none');
    body.classList.add('no-scroll');
}

mainMenuBtn.addEventListener('click', showMainMenu);
document.querySelector('.main-menu-container-spacer').addEventListener('click', hideMainMenu);

function showMioAutodocMainMenu(event) {
    const allMainMenuElement = document.querySelectorAll('.main-menu-element');
    for (const element of allMainMenuElement) {
        element.classList.add('show-none');
    }
    document.querySelector('#main-menu-mio-autodoc').classList.remove('show-none');
}



function onFetchCartJson(json) {
    console.log(json);

    const totalPrice = json.total_price

    if (totalPrice > 0) {
        const cartTotalLabel = document.querySelector('#cart-total');
        cartTotalLabel.textContent = totalPrice + " €";
        cartTotalLabel.classList.add('orange-text');
        const cartCounter = document.querySelector('#header-cart-counter');
        cartCounter.classList.add('number-circle-selected');

        cartCounter.textContent = json.total_amount;
    }
}

function onFetchCartResponse(response) {
    if (response.status === 200) {
        return response.json();
    }
}

function fetchCart() {
    fetch("fetch_cart.php", {
        method: 'GET'
    }).then(onFetchCartResponse).then(onFetchCartJson);
}

function onAddProductJson(json) {
    console.log(json);
    fetchCart();
}

function onAddProductResponse(response) {
    if (response.status === 200) {
        return response.json();
    }
}

function addToCart(event) {
    const btn = event.currentTarget;

    const addToCartData = new FormData();

    const productId = btn.dataset.product_id;
    addToCartData.append("product_id", productId);

    for (const label of productCartLabelAll) {
        if (label.dataset.product_id === productId) {
            addToCartData.append("amount", label.textContent);
        }
    }

    console.log("passing data: " + addToCartData.get('product_id') + " " + addToCartData.get('amount'));

    fetch("add_to_cart.php", {
        method: 'POST',
        body: addToCartData
    }).then(onAddProductResponse).then(onAddProductJson);

}

let currentPage = 1;
let currentKeyword = ""
const productsPerPage = 10;
const productsContainer = document.querySelector('.products-container');

function onProductsResponse(response) {
    return response.json();
}

function onProductsJson(json) {
    console.log(json);
    if (json.products.length > 0) {
        const products = json.products;
        const total = json.total;
        productsContainer.innerHTML = '';

        for (const product of products) {
            const productElement = document.createElement('div');
            productElement.classList.add('product');

            const productImages = document.createElement('div');
            productImages.classList.add('product-images');

            const brandImage = document.createElement('img');
            brandImage.classList.add('product-logo-image');
            brandImage.src = product.brand_image_path;
            productImages.appendChild(brandImage);

            const productImage = document.createElement('img');
            productImage.src = product.image_path;
            productImages.appendChild(productImage);

            productElement.appendChild(productImages);

            const col1 = document.createElement('div');
            col1.classList.add('col1');

            const productName = document.createElement('span');
            productName.classList.add('product-name');
            productName.textContent = product.name;
            col1.appendChild(productName);

            const productShortDesc = document.createElement('span');
            productShortDesc.classList.add('product-short-desc');
            productShortDesc.textContent = product.short_desc;
            col1.appendChild(productShortDesc);

            const productNumber = document.createElement('span');
            productNumber.classList.add('product-number');
            productNumber.textContent = `Numero articolo: ${product.product_number}`;
            col1.appendChild(productNumber);

            const ratingContainer = document.createElement('div');
            ratingContainer.classList.add('rating-container');

            for (let i = 0; i < product.rating; i++) {
                const star = document.createElement('img');
                star.src = 'assets/star-icon-orange.svg';
                ratingContainer.appendChild(star);
            }

            for (let i = product.rating; i < 5; i++) {
                const starOutline = document.createElement('img');
                starOutline.src = 'assets/star-icon-orange-outline.svg';
                ratingContainer.appendChild(starOutline);
            }

            const reviewSpan = document.createElement('span');
            reviewSpan.textContent = 'Scrivi una recensione';
            ratingContainer.appendChild(reviewSpan);

            col1.appendChild(ratingContainer);

            const productDetails = document.createElement('div');
            productDetails.classList.add('product-details');

            for (const [detailName, detailValue] of Object.entries(product.details)) {
                const detailDiv = document.createElement('div');
                detailDiv.classList.add('detail');

                const detailNameDiv = document.createElement('div');
                detailNameDiv.classList.add('product-detail-name');
                detailNameDiv.textContent = detailName + ":";

                const detailValueDiv = document.createElement('div');
                detailValueDiv.classList.add('product-detail-data');
                detailValueDiv.textContent = detailValue;

                detailDiv.appendChild(detailNameDiv);
                detailDiv.appendChild(detailValueDiv);

                productDetails.appendChild(detailDiv);
            }

            col1.appendChild(productDetails);

            const detailsButton = document.createElement('button');
            detailsButton.classList.add('product-details-btn');

            const arrowIconSvg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
            const arrowIconUse = document.createElementNS("http://www.w3.org/2000/svg", "use");
            arrowIconUse.setAttributeNS("http://www.w3.org/1999/xlink", "xlink:href", "assets/icon-sprite-bw.svg#sprite-right-arrow-icon-bw");

            arrowIconSvg.appendChild(arrowIconUse);

            detailsButton.textContent = 'Dettagli ';
            detailsButton.appendChild(arrowIconSvg);

            col1.appendChild(detailsButton);

            productElement.appendChild(col1);

            const col2 = document.createElement('div');
            col2.classList.add('col2');

            const availabilityDiv = document.createElement('div');
            availabilityDiv.classList.add('available');

            const greenDot = document.createElement('div');
            greenDot.classList.add('green-dot');
            availabilityDiv.appendChild(greenDot);

            availabilityDiv.appendChild(document.createTextNode('Disponibile'));
            col2.appendChild(availabilityDiv);

            const productPrice = document.createElement('span');
            productPrice.classList.add('product-price');
            productPrice.textContent = product.price.replace('.', ',') + "€";
            col2.appendChild(productPrice);

            const productVat = document.createElement('span');
            productVat.classList.add('product-vat');
            const productVatRow1 = document.createTextNode('Prezzo incl. IVA 22%');
            productVat.appendChild(productVatRow1);

            const productVatbr = document.createElement('br');
            productVat.appendChild(productVatbr);

            const productVatRow2 = document.createTextNode('escl. spese di spedizione');
            productVat.appendChild(productVatRow2);
            col2.appendChild(productVat);

            const productBuyContainer = document.createElement('div');
            productBuyContainer.classList.add('product-buy-container');

            const productCartContainer = document.createElement('div');
            productCartContainer.classList.add('product-cart-container');

            const productCartLabel = document.createElement('div');
            productCartLabel.classList.add('product-cart-label');
            productCartLabel.dataset.product_id = product.id;

            productCartLabel.textContent = '1';

            productCartContainer.appendChild(productCartLabel);

            const incDecContainer = document.createElement('div');
            incDecContainer.classList.add('product-inc-dec-container');

            const incBtn = document.createElement('div');
            incBtn.classList.add('product-inc-dec', 'inc-btn');
            incBtn.dataset.product_id = product.id;
            const upArrow = document.createElement('div');
            upArrow.classList.add('up-arrow');
            incBtn.appendChild(upArrow);

            incBtn.addEventListener('click', incProduct);

            incDecContainer.appendChild(incBtn);

            const decBtn = document.createElement('div');
            decBtn.classList.add('product-inc-dec', 'dec-btn');
            decBtn.dataset.product_id = product.id;
            const downArrow = document.createElement('div');
            downArrow.classList.add('down-arrow');
            decBtn.appendChild(downArrow);

            decBtn.addEventListener('click', decProduct);

            incDecContainer.appendChild(decBtn);

            productCartContainer.appendChild(incDecContainer);
            productBuyContainer.appendChild(productCartContainer);

            const buyButton = document.createElement('button');
            buyButton.classList.add('product-buy');

            const cartIconSvg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
            cartIconSvg.classList.add('navbar-icon');

            const cartIconUse = document.createElementNS("http://www.w3.org/2000/svg", "use");
            cartIconUse.setAttributeNS("http://www.w3.org/1999/xlink", "xlink:href", "assets/icon-sprite-bw.svg#sprite-basket-icon-bw");

            cartIconSvg.appendChild(cartIconUse);

            buyButton.appendChild(cartIconSvg);


            const buttonText = document.createTextNode(' Comprare');
            buyButton.appendChild(buttonText);

            buyButton.dataset.product_id = product.id;
            buyButton.addEventListener('click', addToCart);
            productBuyContainer.appendChild(buyButton);

            col2.appendChild(productBuyContainer);
            productElement.appendChild(col2);

            productsContainer.appendChild(productElement);
        }

        createPagination(total);
        productCartLabelAll = document.querySelectorAll('.product-cart-label');
        fetchCart();
    } else {
        productsContainer.innerHTML = "";
        const productNotFound = document.createElement('div');
        productNotFound.classList.add('product-not-found');
        productNotFound.textContent = "Trovati 0 risultati per " + currentKeyword;
        productsContainer.appendChild(productNotFound);
    }
}

function createPagination(total) {

    const paginationContainer = document.createElement('div');
    paginationContainer.classList.add('pagination-container');
    paginationContainer.innerHTML = '';

    const totalPages = Math.ceil(total / productsPerPage);

    for (let i = 1; i <= totalPages; i++) {
        const pageButton = document.createElement('button');
        pageButton.textContent = i;
        pageButton.classList.add('pagination-btn');
        if (i === currentPage) {
            pageButton.classList.add('selected');
        }
        pageButton.addEventListener('click', () => {
            currentPage = i;
            fetchProducts(currentKeyword, currentPage);
        });
        paginationContainer.appendChild(pageButton);
        productsContainer.appendChild(paginationContainer);
    }
}

function fetchProducts(keyword, page) {
    const vehicle_id = document.querySelector('#versionSelect').value;
    console.log("v: " + vehicle_id);
    let url = "";
    if (vehicle_id > 0) {
        url = "fetch_products.php?keyword=" + keyword + "&page=" + page + "&limit=" + productsPerPage + "&vehicle_id=" + vehicle_id;
    } else {
        url = "fetch_products.php?keyword=" + keyword + "&page=" + page + "&limit=" + productsPerPage;
    }
    fetch(url).then(onProductsResponse).then(onProductsJson)
}

function setVehicle(id, brand, model, version) {

    brandSelect.value = brand;
    onSelectChanged({ currentTarget: brandSelect });

    setTimeout(function () {
        modelSelect.value = model;
        onSelectChanged({ currentTarget: modelSelect });
        setTimeout(function () {
            versionSelect.value = id;
            versionSelect.text = version;
            onSelectChanged({ currentTarget: versionSelect });

            fetchProducts(keyword, currentPage);
        }, 150);
    }, 150);


}


function onVehicleJson(json) {
    console.log(json);
    if (json.vehicle.id > 0) {
        setVehicle(json.vehicle.id, json.vehicle.brand, json.vehicle.model, json.vehicle.version)
    }
}

function onVehicleResponse(response) {
    if (response.status === 200) {
        return response.json();
    }
}

const urlParams = new URLSearchParams(window.location.search);
const keyword = urlParams.get('keyword');

if (urlParams.get('vehicle_id') > 0) {
    const id = urlParams.get('vehicle_id');
    setTimeout(function () {
        fetch("fetch_vehicle.php?vehicle_id=" + id).then(onVehicleResponse).then(onVehicleJson);
    }, 50);
} else {
    fetchProducts(keyword, currentPage);
}

currentKeyword = keyword;
document.querySelector('#search-input').value = keyword;


function search(event) {
    event.preventDefault()
    const formData = new FormData(event.currentTarget);
    const keyword = formData.get('keyword');
    currentKeyword = keyword;
    currentPage = 1;

    const licencePlate = document.querySelector('#search-by-numbers-input').value;

    if (licencePlate !== "") {
        fetch("fetch_licence_plate.php?licence_plate=" + licencePlate).then(onLicencePlateResponse).then(onLicencePlateJson);
    } else {
        fetchProducts(keyword, currentPage);
    }
}

document.querySelector('.header-search').addEventListener('submit', search);

const cartBtn = document.querySelector('#cart-info');

function onLicencePlateJson(json) {
    console.log(json)

    if (json.vehicle) {
        if (json.vehicle.id !== 0) {
            fetch("fetch_vehicle.php?vehicle_id=" + json.vehicle.id).then(onVehicleResponse).then(onVehicleJson);
        }
    } else {
        if (json.error) {
            document.querySelector('#search-by-numbers-label').textContent = json.error;
        }
    }

}

function onLicencePlateResponse(response) {
    if (response.status === 200) {
        return response.json();
    }
}

function fetchModelByLicence(event) {
    const licencePlate = document.querySelector('#search-by-numbers-input').value;

    if (licencePlate !== "") {
        fetch("fetch_licence_plate.php?licence_plate=" + licencePlate).then(onLicencePlateResponse).then(onLicencePlateJson);
    }
}

document.querySelector('#search-by-numbers-btn').addEventListener('click', fetchModelByLicence);