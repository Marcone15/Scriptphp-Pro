document.addEventListener('DOMContentLoaded', function () {
    const animalButtons = document.querySelectorAll('.btn-animal');
    const listNumbersDiv = document.querySelector('.list-numbers');
    const quantityInput = document.getElementById('quantity_numbers_rn');
    const priceValueSpan = document.querySelector('.price-value');
    const priceTotalSpan = document.querySelector('.price-total-rn');
    const modalNormal = document.querySelector('.modal-normal');
    const addToCartButton = document.querySelector('.btn-add-rn');
    const minNumberInput = document.getElementById('min-number-rn');
    const maxNumberInput = document.getElementById('max-number-rn');
    const modalPayment = document.querySelector('.modal-payment');

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
            quantityInput.value = qtdPromo1.textContent;
            totalPrice = pricePromo1.textContent;
        } else if (qtdPromo2 && quantity === parseInt(qtdPromo2.textContent)) {
            quantityInput.value = qtdPromo2.textContent;
            totalPrice = pricePromo2.textContent;
        } else if (qtdPromo3 && quantity === parseInt(qtdPromo3.textContent)) {
            quantityInput.value = qtdPromo3.textContent;
            totalPrice = pricePromo3.textContent;
        }

        priceTotalSpan.textContent = totalPrice;
    }

    function checkQuantities() {
        const quantity = parseInt(quantityInput.value) || 0;
        const minNumber = parseInt(minNumberInput.value) || 0;
        const maxNumber = parseInt(maxNumberInput.value) || 0;

        if (quantity < minNumber || quantity > maxNumber) {
            addToCartButton.style.pointerEvents = 'none';
            addToCartButton.style.opacity = 0.5;
        } else {
            addToCartButton.style.pointerEvents = 'auto';
            addToCartButton.style.opacity = 1;
        }

        if (quantity >= maxNumber) {
            animalButtons.forEach(button => {
                const hiddenInput = button.querySelector('input[type="hidden"]');
                const animal = hiddenInput ? hiddenInput.value : null;
                const spanExists = listNumbersDiv.querySelector(`span[data-animal="${animal}"]`);
                
                if (!spanExists) {
                    button.style.pointerEvents = 'none';
                    button.style.opacity = 0.5;
                }
            });
        } else {
            animalButtons.forEach(button => {
                button.style.pointerEvents = 'auto';
                button.style.opacity = 1;
            });
        }
    }

    function checkListNumbers() {
        if (listNumbersDiv.querySelectorAll('span').length > 0) {
            modalNormal.style.display = 'flex';
        } else {
            modalNormal.style.display = 'none';
        }
    }

    animalButtons.forEach(button => {
        button.addEventListener('click', function () {
            if (button.style.pointerEvents === 'none') return; 

            const hiddenInput = this.querySelector('input[type="hidden"]');
            const animal = hiddenInput ? hiddenInput.value : null;
            const backgroundAnimal = this.querySelector('.background-animal');

            if (animal) {
                const spanExists = listNumbersDiv.querySelector(`span[data-animal="${animal}"]`);
                if (spanExists) {
                    listNumbersDiv.removeChild(spanExists);
                    backgroundAnimal.style.backgroundColor = 'transparent';
                    quantityInput.value = parseInt(quantityInput.value) - 1;
                } else {
                    const newSpan = document.createElement('span');
                    newSpan.textContent = animal;
                    newSpan.dataset.animal = animal;
                    listNumbersDiv.appendChild(newSpan);
                    backgroundAnimal.style.backgroundColor = '#2b2b2baf';
                    quantityInput.value = parseInt(quantityInput.value) + 1;
                }

                updateTotalPrice();
                checkQuantities();
            }
        });
    });

    addToCartButton.addEventListener('click', function () {
        if (addToCartButton.style.pointerEvents === 'none') return; 

        document.getElementById('quantity').value = quantityInput.value;
        document.querySelector('.quantity-selected').textContent = quantityInput.value;
        document.getElementById('total-amount').value = priceTotalSpan.textContent;

        const selectedNumbers = Array.from(listNumbersDiv.querySelectorAll('span'))
            .map(span => span.textContent)
            .join(', ');
        document.getElementById('numbers-list').value = selectedNumbers;

        modalPayment.style.display = 'flex';
    });

    setInterval(checkListNumbers, 100);
    setInterval(updateTotalPrice, 100);
    setInterval(checkQuantities, 100);
});
