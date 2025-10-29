<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    }
    
    $message = $_SESSION['message'] ?? null;
    $message_type = $_SESSION['message_type'] ?? null;
    unset($_SESSION['message']); unset($_SESSION['message_type']);
?>

<h5 class="title-head" style="display: none;">Cadastrar</h5>
<body>
    <section>
        <div class="back-range" style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;"></div>
        <div class="container" style="height: max-content;">
            <span class="title">
                <h1>📑 Cadastre-se</h1>
            </span>
            <div class="register-form">
            <form action="/register" method="post" enctype="multipart/form-data">

                <label>Nome completo</label>
                <input type="text" name="name" placeholder="Informe seu nome e sobrenome" required>

                <?php if (($settings['field_email']) == true): ?>
                    <label>E-mail</label>
                    <input type="email" name="email" required style="width: 100%">
                <?php endif; ?>

                <label>Celular</label>
                <input type="tel" id="phone" name="phone" maxlength="14">

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

                <div class="section-user-image">
                    <div style="background-image: url('../../public/images/user-image.png');" class="img-user"></div>
                    <div style="padding-left: 10px;">
                        <label>Foto de usuário: <span style="font-size: .85em; font-weight: 300; color: #0000009c;">(Opcional)</span></label>
                        <label for="upload-image-user" class="label-img-user"><i class="bi bi-upload"></i> Escolher arquivo</label>
                        <input type="file" accept="image/*" name="image_user" id="upload-image-user">
                        <div class="name-file" style="font-size: .8em; font-weight: 300;"></div>
                    </div>
                </div>

                <button class="btn-register">Cadastrar <i class="bi bi-arrow-right"></i></button>
                <span class="message-cpf"></span>

                <?php if ($message): ?>
                    <div class="message <?php echo $message_type; ?>" style="border: solid 1px #9eeaf9; background-color: #cff4fc; font-size: .8em; padding: 7px; font-weight: 300; color: #055160;margin-top: 10px; border-radius: 5px;">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
            </form>
            </div>            
        </div>
    </section>
    <script src="../../public/helpers/maskPhone.js"></script>
    <script src="../../public/helpers/maskAge.js"></script>
    <script src="../../public/helpers/maskCPF.js"></script>
    <script src="../../public/helpers/maskCEP.js"></script>
    <script src="../../public/helpers/validateCPF.js"></script>
    <script src="../../public/js/pages/cadastrar.js"></script>
<?php include __DIR__ . '/../partials/footer.php'; ?>
