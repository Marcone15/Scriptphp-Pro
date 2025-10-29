<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<h5 class="title-head" style="display: none;">Comunicados</h5>

<body>
    <section>
        <div class="back-range" style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;"></div>
        <div class="container" style="height: max-content;">
            <span class="title">
                <h1>📰 Comunicados</h1>
            </span>

            <?php if (!empty($communications)): ?>
            <?php 
            $count = 0;
            foreach ($communications as $communication): 
                if ($count >= 6) break;
                $count++;
            ?>
                <div class="communications">
                    <div class="header-communications">
                        <h4>COMUNICADO IMPORTANTE</h4>
                        <p><?php echo date('d/m/Y', strtotime(htmlspecialchars($communication['created_at']))); ?></p>
                    </div>

                    <div class="communication">
                        <?php echo htmlspecialchars($communication['communication']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>



            
        </div>
    </section>
    <script src="../../public/js/pages/campanhas.js"></script>
<?php include __DIR__ . '/../partials/footer.php'; ?>


