<?php include __DIR__ . '/../partials/header.php'; ?>
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
    <section class="dashboard-container">
        <div class="login-admin">
            <div class="login-admin-form">
                <h3>Login</h3>
                <form action="/loginAdmin" method="post">
                    <label>E-mail</label>
                    <input type="email" id="email" name="email">

                    <label>Senha</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" required>
                        <i class="bi bi-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
                    </div>

                    <button class="btn-register">
                        <span class="btn-text">Entrar <i class="bi bi-arrow-right"></i></span>
                        <img class="spinner-gif" src="../../public/images/spinner.gif" alt="spinner" style="max-width: 20px; display: none;">
                    </button>

                    <?php if ($message): ?>
                        <div class="message <?php echo $message_type; ?>" style="border: solid 1px #9eeaf9; background-color: #cff4fc; font-size: .8em; padding: 7px; font-weight: 300; color: #055160; border-radius: 5px; margin-top: 10px;">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>
                </form>
            </div>            
        </div>
    </section>
    <script src="../../public/js/dashboard/login.js"></script>
    <script src="../../public/js/pages/login.js"></script>
</body>


