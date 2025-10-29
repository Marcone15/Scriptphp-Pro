<?php
$select = explode(', ', htmlspecialchars($campaign['qtd_select']));
$qtdNumbers = $campaign['qtd_numbers'];
$percentNumbers =  $numbersSoldPercentage;  
$numbersPending = $reservadosPagosLivres['reservados'] ? $reservadosPagosLivres['reservados'] : 0;
$totalNumbersAvailable = ceil($qtdNumbers - ($qtdNumbers * ($percentNumbers / 100)) - $numbersPending);
?>
 
    <div class="select-single">
        <p>Quanto mais títulos, mais chances de ganhar!</p>
        <div class="content-select">
            <div class="select select-1" style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;">
                <span>+
                    <h3>
                    <?php echo isset($select[0]) && $select[0] !== '' ? $select[0] : '0'; ?>
                    </h3>
                </span>
                <p>SELECIONAR</p>
            </div>
            <div class="select select-2" style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;">
                <span>+
                    <h3>
                    <?php echo isset($select[1]) && $select[1] !== '' ? $select[1] : '0'; ?>
                    </h3>
                </span>
                <p>SELECIONAR</p>
            </div>
            <div class="select select-3 popular">
                <button>Mais popular</button>
                <span>+
                    <h3>
                    <?php echo isset($select[2]) && $select[2] !== '' ? $select[2] : '0'; ?>
                    </h3>
                </span>
                <p>SELECIONAR</p>
            </div>
            <div class="select select-4" style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;">
                <span>+
                    <h3>
                    <?php echo isset($select[3]) && $select[3] !== '' ? $select[3] : '0'; ?>
                    </h3>
                </span>
                <p>SELECIONAR</p>
            </div>
            <div class="select select-5" style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;">
                <span>+
                    <h3>
                    <?php echo isset($select[4]) && $select[4] !== '' ? $select[4] : '0'; ?>
                    </h3>
                </span>
                <p>SELECIONAR</p>
            </div>
            <div class="select select-6" style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;">
                <span>+
                    <h3>
                    <?php echo isset($select[5]) && $select[5] !== '' ? $select[5] : '0'; ?>
                    </h3>
                </span>
                <p>SELECIONAR</p>
            </div>
        </div>
        <div class="add-to-cart">
            <div class="quantity-input">
                <i class="bi bi-dash-circle"></i>
                <input class="input-quantity" type="number" value="<?php echo htmlspecialchars($campaign['qtd_min']); ?>">
                <i class="bi bi-plus-circle-fill" style="color: <?php echo htmlspecialchars($settings['color_website']); ?>;"></i>
                <input class="max-value" type="hidden" value="<?php echo htmlspecialchars($campaign['qtd_max']); ?>">
            </div>
            <div class="btn-add-to-cart">
                <i class="bi bi-arrow-right-square-fill"></i>
                <span>
                    <h3>Participar</h3>
                    <span class="participate">R$
                        <p class="price-participate">
                            0,00
                        </p>
                    </span>
                </span>
            </div>
        </div>
    </div>

    <div class="numbersRest" style="color: #664d03; font-weight: 300; font-size: .8em; background-color: #fff3cd; border: solid 1px #ffe69c; border-radius: 7px; box-shadow: none; padding: 7px; margin-top: 7px; display: none;">
        <p>Restam apenas <span class="rest-numbers"> 0</span> Títulos.</p>
    </div>
    
    <script src="../../public/js/partials/automatic.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalNumbersAvailable = <?php echo json_encode($totalNumbersAvailable); ?>;

        const inputQuantity = document.querySelector('.input-quantity');
        const btnAddToCart = document.querySelector('.btn-add-to-cart');
        const numbersRestDiv = document.querySelector('.numbersRest');
        const restNumbersSpan = document.querySelector('.rest-numbers');

        function updateAvailability() {
            const quantity = parseInt(inputQuantity.value, 10);
            if (quantity > totalNumbersAvailable) {
                btnAddToCart.style.pointerEvents = 'none';
                btnAddToCart.style.opacity = '0.5';
                numbersRestDiv.style.display = 'block';
                restNumbersSpan.textContent = totalNumbersAvailable;
            } else {
                btnAddToCart.style.pointerEvents = 'auto';
                btnAddToCart.style.opacity = '1';
                numbersRestDiv.style.display = 'none';
            }
        }

        setInterval(updateAvailability, 500);

        updateAvailability();
    });
</script>
