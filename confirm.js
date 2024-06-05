function onOrderJson(json) {
    console.log(json);

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



            productDetails.appendChild(productName);
            productDetails.appendChild(productShortDesc);
            productDetails.appendChild(productNumber);

            const cartDetails = document.createElement('div');
            cartDetails.classList.add('cart-details');

            const productCartContainer = document.createElement('div');
            productCartContainer.classList.add('product-cart-container');

            const productCartLabel = document.createElement('div');
            productCartLabel.classList.add('product-cart-label');
            productCartLabel.textContent = '×' + product.amount;

            productCartContainer.appendChild(productCartLabel);


            const productPrice = document.createElement('span');
            productPrice.classList.add('product-price');
            productPrice.textContent = product.price + ' €';

            cartDetails.appendChild(productCartContainer);
            cartDetails.appendChild(productPrice);


            productElement.appendChild(productImages);
            productElement.appendChild(productDetails);
            productElement.appendChild(cartDetails);

            productContainer.appendChild(productElement);
            productsContainer.appendChild(productContainer);
        }


        const addressContainer = document.querySelector('.address-container');

        const addressData = json.address_data[0];

        for (const [key, value] of Object.entries(addressData)) {

            if (value !== null) {
                const divRow = document.createElement('div');
                divRow.classList.add('table-row');

                const item = document.createElement('span');
                item.textContent = key;

                const valueSpan = document.createElement('span');

                if (value === '0') {
                    valueSpan.textContent = 'No';
                } else if (value === '1') {
                    valueSpan.textContent = 'Si';
                } else {
                    valueSpan.textContent = value;
                }

                divRow.appendChild(item);
                divRow.appendChild(valueSpan);

                addressContainer.appendChild(divRow);
            }
        }

        if (json.receipt_url !== null) {
            document.querySelector('.receipt').href = json.receipt_url;
        }

    } else {
        productsContainer.innerHTML = 'Il carrello è vuoto';
        document.querySelector('#total-price-products').textContent = '0,00 €';
        document.querySelector('#total-price-order').textContent = '0,00 €';
    }

}

function onOrderResponse(response) {
    if (response.status === 200) {
        return response.json();
    }
}

fetch("fetch_order.php").then(onOrderResponse).then(onOrderJson);