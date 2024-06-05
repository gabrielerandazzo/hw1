const productsContainer = document.querySelector('.products-container');

function expandProductsDetails(event) {
    const btn = event.currentTarget;
    const productDetailsAll = document.querySelectorAll('.all-product-details');

    for (const productDetails of productDetailsAll) {
        if (productDetails.dataset.product_id === btn.dataset.product_id) {

            if (productDetails.classList.contains('show-none')) {

                productDetails.classList.remove('show-none');
                productDetails.classList.add('show-flex');

                btn.textContent = 'Meno info';
            } else {

                productDetails.classList.remove('show-flex');
                productDetails.classList.add('show-none');

                btn.textContent = 'Più info';
            }
        }
    }
}

function onProductUpdatedJson(json) {
    console.log(json);
    fetchCart();
}

function onProductUpdated(response) {
    console.log(response);

    if (response.status === 200) {
        return response.json();
    }
}

function removeFromCart(event) {
    const btn = event.currentTarget;
    const formData = new FormData()

    formData.append("product_id", btn.dataset.product_id);
    formData.append("amount", 0);

    fetch("update_product_amount.php", {
        method: 'POST',
        body: formData
    }).then(onProductUpdated).then(onProductUpdatedJson);

}

function incProductAmount(event) {
    const btn = event.currentTarget;
    const productId = btn.dataset.product_id;
    const amount = parseInt(btn.dataset.amount, 10) + 1;

    const formData = new FormData();

    formData.append("product_id", productId);
    formData.append("amount", amount);

    fetch("update_product_amount.php", {
        method: 'POST',
        body: formData
    }).then(onProductUpdated).then(onProductUpdatedJson);

}

function decProductAmount(event) {
    const btn = event.currentTarget;
    const productId = btn.dataset.product_id;
    const amount = parseInt(btn.dataset.amount, 10) - 1;

    const formData = new FormData();

    formData.append("product_id", productId);
    formData.append("amount", amount);

    fetch("update_product_amount.php", {
        method: 'POST',
        body: formData
    }).then(onProductUpdated).then(onProductUpdatedJson)
}

function onFetchCartJson(json) {
    if (json.products.length > 0) {
        const products = json.products;
        const productsContainer = document.querySelector('.products-container');
        productsContainer.innerHTML = '';

        document.querySelector('#total-price-products').textContent = json.total_price + ' €';
        document.querySelector('#total-price-order').textContent = json.total_price + ' €';

        for (const product of products) {
            const productContainer = document.createElement('div');
            productContainer.classList.add('product-container');

            const productElement = document.createElement('div');
            productElement.classList.add('product');

            const productImages = document.createElement('div');
            productImages.classList.add('product-images');

            const brandImage = document.createElement('img');
            brandImage.src = product.brand_image_path;
            brandImage.classList.add('product-brand-image');

            const productImage = document.createElement('img');
            productImage.src = product.image_path;
            productImage.classList.add('product-image');

            productImages.appendChild(brandImage);
            productImages.appendChild(productImage);

            const productDetails = document.createElement('div');
            productDetails.classList.add('product-details');

            const productName = document.createElement('span');
            productName.classList.add('product-name');
            productName.textContent = product.name;

            const productShortDesc = document.createElement('span');
            productShortDesc.classList.add('product-short-desc');
            productShortDesc.textContent = product.short_desc;

            const productNumber = document.createElement('span');
            productNumber.classList.add('product-number');
            productNumber.textContent = 'Numero articolo: ' + product.product_number;

            const wishlistContainer = document.createElement('div');
            wishlistContainer.classList.add('wishlist-container');

            const wishlistSvg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
            const useElement = document.createElementNS("http://www.w3.org/2000/svg", "use");
            useElement.setAttributeNS("http://www.w3.org/1999/xlink", "xlink:href", "assets/basket-sprite.svg#wishlist");
            wishlistSvg.appendChild(useElement);

            const wishlistText = document.createElement('span');
            wishlistText.classList.add('wishlist-text');
            wishlistText.textContent = 'Aggiungere alla lista dei desideri';

            wishlistContainer.appendChild(wishlistSvg);
            wishlistContainer.appendChild(wishlistText);

            const expandProductDetails = document.createElement('div');
            expandProductDetails.classList.add('expand-product-details');
            expandProductDetails.textContent = 'Più info';

            const downArrowFilled = document.createElement('span');
            downArrowFilled.classList.add('down-arrow-filled');
            expandProductDetails.appendChild(downArrowFilled);

            productDetails.appendChild(productName);
            productDetails.appendChild(productShortDesc);
            productDetails.appendChild(productNumber);
            productDetails.appendChild(wishlistContainer);
            productDetails.appendChild(expandProductDetails);

            const cartDetails = document.createElement('div');
            cartDetails.classList.add('cart-details');

            const productCartContainer = document.createElement('div');
            productCartContainer.classList.add('product-cart-container');

            const productCartLabel = document.createElement('div');
            productCartLabel.classList.add('product-cart-label');
            productCartLabel.textContent = product.amount;

            const productIncDecContainer = document.createElement('div');
            productIncDecContainer.classList.add('product-inc-dec-container');

            const incBtn = document.createElement('div');
            incBtn.classList.add('product-inc-dec');

            const upArrow = document.createElement('div');
            upArrow.classList.add('up-arrow');
            incBtn.appendChild(upArrow);

            incBtn.dataset.product_id = product.id;
            incBtn.dataset.amount = product.amount;
            incBtn.addEventListener('click', incProductAmount);

            const decBtn = document.createElement('div');
            decBtn.classList.add('product-inc-dec');

            const downArrow = document.createElement('div');
            downArrow.classList.add('down-arrow');
            decBtn.appendChild(downArrow);

            decBtn.dataset.amount = product.amount;
            decBtn.dataset.product_id = product.id;
            decBtn.addEventListener('click', decProductAmount);

            productIncDecContainer.appendChild(incBtn);
            productIncDecContainer.appendChild(decBtn);

            productCartContainer.appendChild(productCartLabel);
            productCartContainer.appendChild(productIncDecContainer);

            const productPrice = document.createElement('span');
            productPrice.classList.add('product-price');
            productPrice.textContent = parseFloat(product.price).toFixed(2) + ' €';

            cartDetails.appendChild(productCartContainer);
            cartDetails.appendChild(productPrice);

            const deleteBtn = document.createElement('div');
            deleteBtn.classList.add('delete-btn');
            deleteBtn.textContent = '×';
            deleteBtn.dataset.product_id = product.id;
            deleteBtn.addEventListener('click', removeFromCart);

            const productDetailsSection = document.createElement('div');
            productDetailsSection.classList.add('all-product-details', 'show-none');
            productDetailsSection.dataset.product_id = product.id;

            const details = JSON.parse(product.details);
            for (const key in details) {
                if (details.hasOwnProperty(key)) {

                    const detailItem = document.createElement('p');
                    detailItem.innerHTML = key + ': ' + details[key];
                    productDetailsSection.appendChild(detailItem);
                }
            }

            expandProductDetails.addEventListener('click', expandProductsDetails);
            expandProductDetails.dataset.product_id = product.id;

            productElement.appendChild(productImages);
            productElement.appendChild(productDetails);
            productElement.appendChild(cartDetails);
            productElement.appendChild(deleteBtn);

            productContainer.appendChild(productElement);
            productContainer.appendChild(productDetailsSection);

            productsContainer.appendChild(productContainer);
        }

        const allFavoriteBtn = document.createElement('button');
        allFavoriteBtn.className = 'all-favorite-btn';

        allFavoriteBtn.innerHTML = '';

        const allFavoriteBtnSvg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        const useElement = document.createElementNS("http://www.w3.org/2000/svg", "use");
        useElement.setAttributeNS("http://www.w3.org/1999/xlink", "xlink:href", "assets/basket-sprite.svg#wishlist");

        allFavoriteBtnSvg.appendChild(useElement);

        const allFavoriteBtnText = document.createTextNode(" Aggiungere tutti gli articoli alla mia lista dei desideri");

        allFavoriteBtn.appendChild(allFavoriteBtnSvg);
        allFavoriteBtn.appendChild(allFavoriteBtnText);

        productsContainer.appendChild(allFavoriteBtn);
    } else {
        productsContainer.innerHTML = 'Il carrello è vuoto';
        document.querySelector('#total-price-products').textContent = '0,00 €';
        document.querySelector('#total-price-order').textContent = '0,00 €';
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