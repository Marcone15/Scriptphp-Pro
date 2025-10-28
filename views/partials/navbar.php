<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userName = $_SESSION['user']['name'] ?? 'Guest';
$userPhone = $_SESSION['user']['phone'] ?? 'N/A';
$userImage = $_SESSION['user']['image_user'] ?? 'default-image.png';
?>

<nav style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;">
    <div class="container-nav">
        <div class="header-nav">
            <a href="/">
                <img src="../../public/images/<?php echo htmlspecialchars($settings['image_logo']); ?>" alt="logo">
            </a>
            
            <i class="bi bi-filter-left" id="showPopupButton"></i>
        </div>

        <div class="popup-nav" style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;">
            <div class="container-popup-nav">
                <div class="header-popup">
                <a href="/"><img src="../../public/images/<?php echo htmlspecialchars($settings['image_logo']); ?>" alt="logo"></a>
                <i class="bi bi-x-circle" id="closePopupButton"></i>
                </div>
                
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="target-user">
                        <div class="img-user-nav" style="background-image: url('../../public/images/<?php echo htmlspecialchars($_SESSION['user']['image_user']); ?>');"></div>
                        <h4>Olá, <?php echo substr(htmlspecialchars($_SESSION['user']['name']), 0, 20); ?></h4>
                        <a href="/logout"><i class="bi bi-box-arrow-left"></i></a>
                    </div>
                <?php endif; ?>

                <div class="options-nav">
                    <ul>
                        <li><a href="/"><i class="icone bi bi-house"></i>Início</a></li>
                        <li><a href="/campanhas"><i class="icone bi bi-card-list"></i>Campanhas</a></li>
                        <li><a href="/comunicados"><i class="icone bi bi-newspaper"></i>Comunicados</a></li>
                        <li><a href="/meus-numeros"><i class="icone bi bi-ui-checks"></i>Meus títulos</a></li>
                        <li><a href="/cadastrar"><i class="icone bi bi-box-arrow-in-right"></i>Cadastro</a></li>
                        <li><a href="/ganhadores"><i class="icone bi bi-trophy"></i>Ganhadores</li></a>
                        <a href="/termo-de-uso"><li><i class="icone bi bi-blockquote-right"></i>Termos de uso</a></li>
                        <li><a href="/contato"><i class="icone bi bi-envelope"></i>Entrar em contato</a></li>
                    </ul>
                    <?php if (!isset($_SESSION['user'])): ?>
                    <a href="/login"><button><i class="bi bi-box-arrow-in-right" style="padding-right: 7px; background: transparent;"></i>Entrar</button></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</nav>
<script src="../../public/js/partials/navbar.js"></script>