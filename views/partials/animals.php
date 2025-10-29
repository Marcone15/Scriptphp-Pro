<div class="normal-single">
    <div class="normal-title">
        <h4>⚡ Cotas</h4>
        <p>Escolha sua sorte</p>
    </div>

    <div class="controls-normal">
        <div class="btn-normal">
            <span>Livres</span>
            <span class="result-livres"><?php echo isset($reservadosPagosLivres['livres']) ? htmlspecialchars($reservadosPagosLivres['livres']) : '0'; ?></span>
        </div>
        <div class="btn-normal">
            <span class="reserv"></span>
            <span class="result-reservados"><?php echo isset($reservadosPagosLivres['reservados']) ? htmlspecialchars($reservadosPagosLivres['reservados']) : '0'; ?></span>
        </div>
        <div class="btn-normal">
            <span>Pagos</span>
            <span class="result-pagos"><?php echo isset($reservadosPagosLivres['pagos']) ? htmlspecialchars($reservadosPagosLivres['pagos']) : '0'; ?></span>
        </div>
    </div>   
    
    <div class="select-animals">
        <?php 
        $animal = ['Avestruz', 'Águia', 'Burro', 'Borboleta', 'Cachorro', 'Cabra', 'Carneiro', 'Camelo', 'Cobra', 'Coelho', 'Cavalo', 'Elefante', 'Galo', 'Gato', 'Jacaré', 'Leão', 'Macaco', 'Porco', 'Pavão', 'Peru', 'Touro', 'Tigre', 'Urso', 'Veado', 'Vaca'];
        $number = $campaign['qtd_numbers']; 
        $numbersStatus = $this->campaignModel->getNumbersStatus($campaign['id']);
        ?>
        
        <?php for ($i = 0; $i < $number; $i++) { 
            $backgroundStyle = '';
            $disabled = '';
            if (isset($numbersStatus[$animal[$i]])) {
                if ($numbersStatus[$animal[$i]] === 'pendente') {
                    $backgroundStyle = 'background-color: #0dcaf075;';
                    $disabled = 'pointer-events: none;';
                } elseif ($numbersStatus[$animal[$i]] === 'pago') {
                    $backgroundStyle = 'background-color: #198754a2;';
                    $disabled = 'pointer-events: none;';
                }
            }
        ?>
            <span class="btn-animal" style="<?php echo $disabled; ?>">
                <img src="../../public/images/animals/<?php echo $i?>.png" alt="<?php echo $i?>.png">
                <span class="background-animal" style="<?php echo $backgroundStyle; ?>"></span>
                <?php if (!$disabled): ?>
                    <input type="hidden" value="<?php echo $animal[$i] ?>" class="animal-index-<?php echo $i ?>">
                <?php endif; ?>
            </span>
        <?php } ?>
    </div>

    <div class="modal-normal" style="display: none;">
        <div class="modal-normal-content">
            <div class="list-numbers"></div>
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
<script src="../../public/js/partials/animals.js"></script>
