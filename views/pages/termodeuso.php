<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<h5 class="title-head" style="display: none;">Termo de uso</h5>

<body>
    <section>
        <div class="back-range" style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;"></div>
        <div class="container" style="height: max-content;">
            <span class="title">
                <h1>📑 Termos de utilização</h1>
            </span>
            <div class="term-of-use">
                <?php echo htmlspecialchars_decode($settings['term_use']); ?> 
            </div>            
        </div>
    </section>
<?php include __DIR__ . '/../partials/footer.php'; ?>


