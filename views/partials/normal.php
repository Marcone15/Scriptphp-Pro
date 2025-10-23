<div class="normal-single">
    <div class="normal-title">
        <h4>⚡ Cotas</h4>
        <p>Escolha sua sorte</p>
    </div>

    <div class="controls-normal">
        <div class="btn-normal">
            <span>Livres</span>
            <span class="result-livres"><?php echo htmlspecialchars($reservadosPagosLivres['livres']); ?></span>
        </div>
        <div class="btn-normal">
            <span class="reserv"></span>
            <span class="result-reservados">
                <?php echo htmlspecialchars(isset($reservadosPagosLivres['reservados']) ? $reservadosPagosLivres['reservados'] : '0'); ?>
            </span>
        </div>
        <div class="btn-normal">
            <span>Pagos</span>
            <span class="result-pagos">
                <?php echo htmlspecialchars(isset($reservadosPagosLivres['pagos']) ? $reservadosPagosLivres['pagos'] : '0'); ?>
            </span>
        </div>
    </div>

    <div class="select-normal">
        <input type="number" placeholder="Digite um número">
        <div class="numbers-normal">
        <?php 
            $numbersStatus = $this->campaignModel->getNumbersStatus($campaign['id']); 
            $number = $campaign['qtd_numbers'];
            $numLength = strlen($number) -1;
            for ($i = 0; $i < $number; $i++) { 
                $formattedNumber = str_pad($i, $numLength, '0', STR_PAD_LEFT);
                $buttonClass = '';
                $buttonStyle = '';
                if (isset($numbersStatus[$formattedNumber])) {
                    if ($numbersStatus[$formattedNumber] === 'pendente') {
                        $buttonClass = 'disabled';
                        $buttonStyle = 'background-color: #0DCAF0;';
                    } elseif ($numbersStatus[$formattedNumber] === 'pago') {
                        $buttonClass = 'disabled';
                        $buttonStyle = 'background-color: #198754;';
                    }
                }
            ?>
                <button class="btn-select <?php echo $buttonClass; ?>" style="<?php echo $buttonStyle; ?>" <?php echo $buttonClass ? 'disabled' : ''; ?>>
                    <p><?php echo htmlspecialchars($formattedNumber); ?></p>
                    <input type="hidden" value="<?php echo htmlspecialchars($formattedNumber); ?>" class="number-<?php echo $formattedNumber; ?>">
                </button>
            <?php } ?>

        </div>
    </div>

    <div class="modal-normal" style="display: none;">
        <div class="modal-normal-content">
            <div class="list-numbers">
            </div>
            <div class="add-to-cart-normal">
                <div class="input-quantity-raffle-normal">
                    <input type="text" value="0" id="quantity_numbers_rn">
                </div>
                <div class="btn-add-rn">
                    <div class="icon-rn">
                        <i class="bi bi-arrow-right-square-fill"></i>
                    </div>
                    <div class="participate-raffle-normal">
                        <h3>Participar</h3> 
                        <p>R$ <span class="price-total-rn">0,00</span></p>
                        <input type="hidden" id="min-number-rn" value="<?php echo htmlspecialchars($campaign['qtd_min']); ?>">
                        <input type="hidden" id="max-number-rn" value="<?php echo htmlspecialchars($campaign['qtd_max']); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../../public/js/partials/normal.js"></script>








