<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<h5 class="title-head" style="display: none;">Login</h5>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    
$message = $_SESSION['message'] ?? null;
$message_type = $_SESSION['message_type'] ?? null;

unset($_SESSION['message']);
unset($_SESSION['message_type']);
?>

<body>
    <section>
        <div class="back-range" style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;"></div>
        <div class="container" style="height: max-content;">
            <span class="title">
                <h1>📑 Login</h1>
            </span>
            <div class="register-form">
                <form action="/loginUser" method="post">
                    <label>Telefone</label>
                    <input type="tel" id="phone" name="phone" maxlength="14" required>

                    <label>Senha</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" required>
                        <i class="bi bi-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
                    </div>

                    <button class="btn-register">Entrar <i class="bi bi-arrow-right"></i></button>
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
    <script src="../../public/js/pages/login.js"></script>
    <script src="../../public/helpers/maskPhone.js"></script>
<?php include __DIR__ . '/../partials/footer.php'; ?>

