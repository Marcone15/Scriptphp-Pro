document.addEventListener('DOMContentLoaded', function () {
    const selectNormal = document.querySelector('.select-normal input[type="number"]');
    const buttons = document.querySelectorAll('.btn-select');

    selectNormal.addEventListener('input', function (event) {
        const inputValue = event.target.value;
        buttons.forEach(button => {
            const hiddenInput = button.querySelector('input[type="hidden"]');
            if (inputValue && !hiddenInput.value.includes(inputValue)) {
                button.style.display = 'none';
            } else {
                button.style.display = 'block';
            }
        });
    });
});

document.querySelectorAll('.btn-select').forEach(button => {
    button.addEventListener('click', function() {
        const hiddenInput = this.querySelector('input[type="hidden"]');
        const number = hiddenInput.value;
        const listNumbers = document.querySelector('.list-numbers');
        const quantityInput = document.getElementById('quantity_numbers_rn');
        const totalValueSpan = document.querySelector('.price-total-rn');
        const priceValue = parseFloat(document.querySelector('.price-value').textContent.replace(',', '.'));

        if (this.classList.contains('selected')) {
            this.classList.remove('selected');
            this.style.backgroundColor = '';
            const spanToRemove = listNumbers.querySelector(`span[data-number="${number}"]`);
            if (spanToRemove) {
                listNumbers.removeChild(spanToRemove);
            }
            quantityInput.value = parseInt(quantityInput.value) - 1;
            totalValueSpan.textContent = (parseFloat(totalValueSpan.textContent.replace(',', '.')) - priceValue).toFixed(2).replace('.', ',');
        } else {
            this.classList.add('selected');
            this.style.backgroundColor = '#424242';
            const newSpan = document.createElement('span');
            newSpan.textContent = number;
            newSpan.dataset.number = number;
            listNumbers.appendChild(newSpan);
            quantityInput.value = parseInt(quantityInput.value) + 1;
            totalValueSpan.textContent = (parseFloat(totalValueSpan.textContent.replace(',', '.')) + priceValue).toFixed(2).replace('.', ',');
        }

        const modalNormal = document.querySelector('.modal-normal');
        if (parseInt(quantityInput.value) > 0) {
            modalNormal.style.display = 'flex';
        } else {
            modalNormal.style.display = 'none';
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const quantityInput = document.getElementById('quantity_numbers_rn');
    const priceTotalSpan = document.querySelector('.price-total-rn');
    const priceValueSpan = document.querySelector('.price-value');

    const qtdPromo1 = document.querySelector('.qtd_promo_1');
    const qtdPromo2 = document.querySelector('.qtd_promo_2');
    const qtdPromo3 = document.querySelector('.qtd_promo_3');
    const pricePromo1 = document.querySelector('.price_promo_1');
    const pricePromo2 = document.querySelector('.price_promo_2');
    const pricePromo3 = document.querySelector('.price_promo_3');

    function updateTotalPrice() {
        const quantity = parseInt(quantityInput.value) || 0;
        let priceValue = parseFloat(priceValueSpan.textContent.replace(',', '.')) || 0;
        let totalPrice = (quantity * priceValue).toFixed(2).replace('.', ',');

        if (qtdPromo1 && quantity === parseInt(qtdPromo1.textContent)) {
            totalPrice = pricePromo1.textContent;
        } else if (qtdPromo2 && quantity === parseInt(qtdPromo2.textContent)) {
            totalPrice = pricePromo2.textContent;
        } else if (qtdPromo3 && quantity === parseInt(qtdPromo3.textContent)) {
            totalPrice = pricePromo3.textContent;
        }

        priceTotalSpan.textContent = totalPrice;
    }

    quantityInput.addEventListener('input', updateTotalPrice);

    setInterval(updateTotalPrice, 100);
});



document.addEventListener('DOMContentLoaded', function () {
    const quantityInput = document.getElementById('quantity_numbers_rn');
    const minNumber = parseInt(document.getElementById('min-number-rn').value);
    const maxNumber = parseInt(document.getElementById('max-number-rn').value);
    const addToCartButton = document.querySelector('.btn-add-rn');
    const buttons = document.querySelectorAll('.btn-select');

    function checkButtonStates() {
        const quantity = parseInt(quantityInput.value);

        if (quantity < minNumber) {
            addToCartButton.style.pointerEvents = 'none';
            addToCartButton.style.opacity = 0.5;
        } else {
            addToCartButton.style.pointerEvents = 'auto';
            addToCartButton.style.opacity = 1;
        }

        if (quantity >= maxNumber) {
            addToCartButton.style.pointerEvents = 'none';
            addToCartButton.style.opacity = 0.5;
            buttons.forEach(button => {
                const hiddenInput = button.querySelector('input[type="hidden"]');
                const spanExists = document.querySelector(`.list-numbers span[data-number="${hiddenInput.value}"]`);
                if (!spanExists) {
                    button.style.pointerEvents = 'none';
                    button.style.opacity = 0.5;
                }
            });
        } else {
            buttons.forEach(button => {
                button.style.pointerEvents = 'auto';
                button.style.opacity = 1;
            });
        }
    }

    setInterval(checkButtonStates, 100); 
    checkButtonStates(); 
});

document.addEventListener('DOMContentLoaded', function () {
    const addToCartButton = document.querySelector('.btn-add-rn');
    const modalPayment = document.querySelector('.modal-payment');
    const quantityInput = document.getElementById('quantity_numbers_rn');
    const totalAmountInput = document.getElementById('total-amount');
    const quantitySpan = document.querySelector('.quantity-selected');
    const priceTotalSpan = document.querySelector('.price-total-rn');
    const listNumbersInput = document.getElementById('numbers-list');
    const listNumbersDiv = document.querySelector('.list-numbers');
    const mainQuantityInput = document.getElementById('quantity');

    addToCartButton.addEventListener('click', function () {
        modalPayment.style.display = 'flex';

        mainQuantityInput.value = quantityInput.value;
        quantitySpan.textContent = quantityInput.value;

        totalAmountInput.value = priceTotalSpan.textContent;

        const selectedNumbers = Array.from(listNumbersDiv.querySelectorAll('span'))
            .map(span => span.textContent)
            .join(', ');
        listNumbersInput.value = selectedNumbers;
    });

    setInterval(function () {
    }, 100);
});

document.addEventListener('DOMContentLoaded', function () {
    const promoElements = document.querySelectorAll('.qtd_n1, .qtd_n2, .qtd_n3');

    promoElements.forEach(element => {
        element.style.pointerEvents = 'none';
    });
});











