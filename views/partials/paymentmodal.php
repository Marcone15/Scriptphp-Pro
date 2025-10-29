<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'] ?? null;
$phone = $user['phone'] ?? '';
$userName = isset($user['name']) ? "Olá, " . htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') : 'Informe seu telefone';

?>

<div class="modal-payment" style="display: none;">
    <div class="modal-payment-content">
        <div class="header-modal">
            <span>
                <h3>Checkout</h3>
                <i class="bi bi-x"></i>
            </span>
            <span class="target-quantity">
            <p>
                <strong><span class="quantity-selected">0</span></strong> unidade(s) do produto <strong style="padding-left: 5px; text-transform: uppercase;"> <?php echo mb_substr(htmlspecialchars($campaign['name']), 0, 17, 'UTF-8'); ?>...</strong>
            </p>

            </span>
        </div>

        <form action="/compra" method="post" class="form-1" style="display: block;">
            <input type="hidden" name="type_raffle" value="<?php echo htmlspecialchars($campaign['type_raffle']); ?>">
            <input type="hidden" name="id_campaign" value="<?php echo htmlspecialchars($campaign['id']); ?>">
            <input type="hidden" name="campaign" value="<?php echo htmlspecialchars($campaign['name']); ?>">
            <input type="hidden" name="expiration_pix" value="<?php echo htmlspecialchars($campaign['expiration_pix']); ?>">
            <input type="hidden" name="quantity" value="0" id="quantity">
            <input type="hidden" name="total" value="0" id="total-amount">
            <input type="hidden" name="numbers_list" value="0" id="numbers-list">

            <label><?php echo htmlspecialchars($userName); ?></label>
            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
            
            <button type="button" id="btn-continue">Continuar <i class="bi bi-arrow-right"></i> <img src="../../public/images/spinner.gif" alt="spinner" style="max-width: 20px; display: none;"></button>
            <h4>
            Ao realizar este pagamento e confirmar minha compra, declaro ter lido e concordado com os <a href="/termo-de-uso"><strong>termos</strong></a>. 
            </h4>
        </form>

        <form action="" method="post" class="form-2" style="display: none;">
            <p>
                <i class="bi bi-exclamation-circle"></i>
                Usuário não encontrado, registre-se.
            </p>

            <label>Nome completo</label>
                <input type="text" name="name" placeholder="Informe seu nome e sobrenome" required>

                <?php if (($settings['field_email']) == true): ?>
                    <label>E-mail</label>
                    <input type="email" name="email" required style="width: 100%">
                <?php endif; ?>

                <label>Celular</label>
                <input type="tel" id="phone2" name="phone" maxlength="14" style="point-event: none;">

                <?php if (($settings['field_age']) == true): ?>
                <label>Data de nascimento</label>
                <input type="text" name="age" id="age" maxlength="10" required>
                <?php endif; ?>

                <?php if (($settings['field_cpf']) == true): ?>
                <label>CPF</label>
                <input type="text" maxlength="14" name="cpf" id="cpf" required>
                <?php endif; ?>

                <label>Crie uma senha</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" required>
                    <i class="bi bi-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
                </div>

                <?php if (($settings['field_address']) == true): ?>
                <div>
                    <label for="cep">CEP:</label>
                    <input type="text" id="cep" name="cep" maxlength="9" required>
                    
                    <div class="logradouro">
                        <span>
                            <label>Rua</label>
                            <input type="text" id="rua" name="rua" required>
                        </span>
                        <span>
                            <label>Número</label>
                            <input type="text" name="number_house" required>
                        </span>
                    </div>
                    
                    <label>Bairro</label>
                    <input type="text" id="bairro" name="bairro" required>
                    
                    <label>Cidade</label>
                    <input type="text" id="cidade" name="cidade" required>
                    
                    <label>Estado</label>
                    <input type="text" id="estado" name="estado" required>
                </div>
                <?php endif; ?>

            <button class="btn-register" style="outline: none;">Cadastrar <i class="bi bi-arrow-right"></i></button>
            <span class="message-cpf"></span>
        </form>

        <form action="" method="post" class="form-3" style="display: none;">
            <input type="hidden" name="type_raffle" value="<?php echo htmlspecialchars($campaign['type_raffle']); ?>">
            <input type="hidden" name="id_campaign" value="<?php echo htmlspecialchars($campaign['id']); ?>">
            <input type="hidden" name="campaign" value="<?php echo htmlspecialchars($campaign['name']); ?>">
            <input type="hidden" name="expiration_pix" value="<?php echo htmlspecialchars($campaign['expiration_pix']); ?>">
            <input type="hidden" name="quantity" value="0" id="quantity">
            <input type="hidden" name="total" value="0" id="total-amount">
            <input type="hidden" name="numbers_list" value="0" id="numbers-list">

            <p class="target-user-registered">
                <i class="bi bi-check-circle"></i>
                Registrado com sucesso
            </p>
            <label>Informe seu telefone</label>
            <input type="tel" id="phone3" name="phone" required>
            <button class="btn-register-sucess" style="outline: none;">Continuar <i class="bi bi-arrow-right"></i><img src="../../public/images/spinner.gif" alt="spinner" style="max-width: 20px; display: none;"></button>
        </form>
    </div>
</div>

<script src="../../public/helpers/maskPhone.js"></script>
<script src="../../public/helpers/maskAge.js"></script>
<script src="../../public/helpers/maskCPF.js"></script>
<script src="../../public/helpers/maskCEP.js"></script>
<script src="../../public/helpers/validateCPF.js"></script>
<script src="../../public/js/partials/paymentmodal.js"></script>
