<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<h5 class="title-head" style="display: none;">Ganhadores</h5>

<body>
    <section>
        <div class="back-range" style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;"></div>
        <div class="container" style="height: max-content;">
            <span class="title">
                <h1>🏆 Ganhadores</h1>
                <p>confira os sortudos</p>
            </span>
            <div class="winners">
                <div class="grid-winner">
                <?php $count = 0; 
                foreach ($winners as $campaign): 
                    if ($count >= 40) break; 
                    if ($campaign['status'] === 'Concluído'):
                    $winner = isset($campaign['winner']) ? explode(', ', $campaign['winner']) : []; ?>
                    <a href="/campanha/<?php echo htmlspecialchars($campaign['slug']); ?>">
                        <div class="grid-winners">
                            
                            <div class="img-user-home" style="background-image: url('../../public/images/<?php echo htmlspecialchars($winner[0], ENT_QUOTES, 'UTF-8'); ?>')"></div>
                            
                            <div class="info-winner-home">
                                <p><?php echo substr(htmlspecialchars($winner[1], ENT_QUOTES, 'UTF-8'), 0, 15 ); ?></p>

                                <h3><?php echo substr(htmlspecialchars($campaign['name']), 0, 20); ?></h3>

                                <p>Número da sorte: <strong><?php echo htmlspecialchars($winner[2], ENT_QUOTES, 'UTF-8'); ?></strong></p>

                                <?php

                                ?>
                                <p>Data da premiação: <strong><span><?php echo htmlspecialchars($winner[3], ENT_QUOTES, 'UTF-8'); ?></span></strong></p>

                            </div>
                        </div>
                    </a>
                    <?php endif; ?>
                <?php endforeach; ?>                        
                </div>
            </div>          
        </div>
    </section>
<?php include __DIR__ . '/../partials/footer.php'; ?>


