const body = document.querySelector('body');
const shown_image_btn_list = document.querySelectorAll('.shown-image-btn');
const banner_image = document.querySelector('.banner-image');
const more_brands_btn = document.querySelector('.more-text');
const parts_brand_container = document.querySelector('.parts-brand-container');
const footer_links_list = document.querySelectorAll('.footer-links');
const car_brands_container = document.querySelector('.brand-grid-container');

function reset_selected_imagr_btn() {
    for (const btn of shown_image_btn_list) {
        btn.classList.remove('selected');
    }
}

function set_shown_image_btn_by_id(id) {
    let full_id = '#shown-image-btn-' + id;
    let btn = document.querySelector(full_id);
    reset_selected_imagr_btn();
    btn.classList.add('selected');
}

let shown_image = 1;

function set_banner_image_by_id(id) {
    switch (id) {
        case '1':
            banner_image.src = "assets/banner1.jpeg"
            shown_image = 1;
            break;
        case '2':
            banner_image.src = "assets/banner2.jpeg"
            shown_image = 2;
            break;

        case '3':
            banner_image.src = "assets/banner3.jpeg"
            shown_image = 3;
            break;

        case '4':
            banner_image.src = "assets/banner4.jpeg"
            shown_image = 4;
            break;
    }
}

function update_banner_image(event) {
    let btn = event.currentTarget;

    if (btn.classList.contains('selected')) {
        console.log("already selected");
    } else {
        reset_selected_imagr_btn();
        btn.classList.add('selected');
        set_banner_image_by_id(btn.id.charAt(16))
    }
}

for (let btn of shown_image_btn_list) {
    btn.addEventListener("click", update_banner_image);
}

function periodically_update_image() {
    if (shown_image > 3) {
        shown_image = 0;
    }
    shown_image++;
    set_banner_image_by_id(shown_image.toString());
    set_shown_image_btn_by_id(shown_image.toString());
}

setInterval(periodically_update_image, 4000);

let parts_brand_expanded = false;

function expand_brands_section() {
    const all_brands = document.querySelectorAll('.parts-brand-item');
    if (!parts_brand_expanded) {
        parts_brand_expanded = true;
        parts_brand_container.style.flexWrap = "wrap"
        for (const item of all_brands) {
            item.style.display = "flex";
        }
        more_brands_btn.textContent = "Chiudi";
        let up_arrow = document.createElement('span');
        up_arrow.classList.add('more-btn');
        up_arrow.classList.add('close');
        more_brands_btn.appendChild(up_arrow);
    } else {
        parts_brand_expanded = false;
        more_brands_btn.textContent = "Di più";
        let up_arrow = document.createElement('span');
        up_arrow.classList.add('more-btn');
        more_brands_btn.appendChild(up_arrow);
        parts_brand_container.style.flexWrap = "noWrap"
        if (window.innerWidth < 767) {
            for (const item of all_brands) {
                if (item.dataset.index > 2) {
                    item.style.display = "none";
                }
            }
        } else if (window.innerWidth < 990) {
            for (const item of all_brands) {
                if (item.dataset.index > 6) {
                    item.style.display = "none";
                }
            }
        }
    }
}

more_brands_btn.addEventListener("click", expand_brands_section);

function onWindowSizeChanged() {
    let width = window.innerWidth;
    const all_brands = document.querySelectorAll('.parts-brand-item');
    if (!parts_brand_expanded) {
        if (width > 760 && width < 990) {
            for (const item of all_brands) {
                if (item.dataset.index <= 6) {
                    item.style.display = "flex";
                }
            }
        } else if (width > 990) {
            for (const item of all_brands) {
                item.style.display = "flex";
            }
        } else {
            for (const item of all_brands) {
                if (item.dataset.index > 2) {
                    item.style.display = "none";
                }
            }
        }
    }
}
window.addEventListener("resize", onWindowSizeChanged);

let footer_links_expanded = false;

function expand_footer_links(event) {
    const all_links_item = document.querySelectorAll('.footer-links-item');
    let index = event.currentTarget.dataset.index;
    if (!footer_links_expanded) {
        event.currentTarget.style.height = 'auto'
        for (const item of all_links_item) {
            if (item.dataset.index === index) {
                item.style.display = "flex"
            }
        }
        footer_links_expanded = true;
    } else {
        event.currentTarget.style.height = '48px'
        for (const item of all_links_item) {
            if (item.dataset.index === index) {
                item.style.display = "none"
            }
        }
        footer_links_expanded = false;
    }

}

for (const item of footer_links_list) {
    item.addEventListener('click', expand_footer_links);
}

const car_brands_array = [
    "assets/fiat.svg",
    "assets/vw.svg",
    "assets/bmw.svg",
    "assets/mercedes.svg",
    "assets/audi.svg",
    "assets/ford.svg",
    "assets/opel.svg",
    "assets/alfa.svg",
    "assets/peugeot.svg",
    "assets/citroen.svg",
    "assets/toyota.svg",
    "assets/nissan.svg",
    "assets/lancia.svg",
    "assets/mini.svg",
    "assets/hyundai.svg",
    "assets/fiat.svg"
];

for (const image of car_brands_array) {
    let image_container = document.createElement('div');
    let brand_image = document.createElement('img');

    image_container.classList.add('brand-grid-item');
    brand_image.classList.add('brand-grid-item-image');

    brand_image.src = image;

    image_container.appendChild(brand_image);

    car_brands_container.appendChild(image_container);
}

const signup_modal = document.querySelector('.signup-modal-container');

const login_modal = document.querySelector('.login-modal-container');

function showSignupModal(event) {
    console.log("ciao")
    signup_modal.classList.remove('show-none');
    if (!login_modal.classList.contains('show-none')) {
        login_modal.classList.add('show-none');
        body.classList.add('no-scroll');
    }
}

function showLoginModal(event) {
    login_modal.classList.remove('show-none');
    body.classList.add('no-scroll');
}

const header_login_btn = document.querySelector('#header-login');

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

function alreadyLogged(event) {

}

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
                nameLabel.textContent = message;
                break;
            case 2:
                surnameLabel.textContent = message;
                break;
            case 3:
                emailLabel.textContent = message;
                break;
            case 4:
                passwordLabel.textContent = message;
                break;
            case 5:
                emailLabel.textContent = message;
                break;
            case 6:
                emailLabel.textContent = message;
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
    const selectedText = select.options[select.selectedIndex].text;
    select.previousElementSibling.textContent = selectedText;

    console.log("select value: " + select.value);

    if (select.dataset.index === "1") {

        modelSelect.innerHTML = '<option value="0" selected>Scegliere il modello</option>';
        document.querySelector('#modelText').textContent = "Scegliere il modello"

        versionSelect.innerHTML = '<option value="0">Scegliere la versione</option>';
        document.querySelector('#versionText').textContent = "Scegliere la versione"

        if (select.value !== 0) {
            fetch('fetch_vehicles.php?request=model&brand=' + brandSelect.value, {
                method: 'GET'
            }).then(onBrandResponse).then(onBandJson);
        }
    } else if (select.dataset.index === "2") {

        versionSelect.innerHTML = '<option value="0">Scegliere la versione</option>';
        document.querySelector('#versionText').textContent = "Scegliere la versione"

        if (modelSelect.value !== 0) {
            fetch('fetch_vehicles.php?request=version&brand=' + brandSelect.value + '&model=' + modelSelect.value, {
                method: 'GET'
            }).then(onBrandResponse).then(onBandJson);
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

fetchCart();

function onLicencePlateJson(json) {
    console.log(json)

    const keyword = document.querySelector('#search-input').value;

    if (json.vehicle) {
        if (json.vehicle.id !== 0) {
            location.href = "products.php?keyword=" + keyword + "&vehicle_id=" + json.vehicle.id;
        } else {
            location.href = "products.php?keyword=" + keyword;
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

function search(event) {
    event.preventDefault()
    const keyword = document.querySelector('#search-input').value;

    const licencePlate = document.querySelector('#search-by-numbers-input').value;

    if (licencePlate !== "") {
        fetch("fetch_licence_plate.php?licence_plate=" + licencePlate).then(onLicencePlateResponse).then(onLicencePlateJson);
    } else {
        if (versionSelect.value > 0) {
            location.href = "products.php?keyword=" + keyword + "&vehicle_id=" + versionSelect.value;
        } else {
            location.href = "products.php?keyword=" + keyword;
        }
    }

}

document.querySelector('.header-search').addEventListener('submit', search);

document.querySelector('#search-by-numbers-btn').addEventListener('click', search);