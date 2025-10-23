<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<h5 class="title-head" style="display: none;">Campanhas</h5>

<body>
    <section>
        <div class="back-range" style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;"></div>
        <div class="container" style="height: max-content;">
            <span class="title">
                <h1>⚡ Campanhas</h1>
                <p>Escolha sua sorte</p>
            </span>
            <div class="control-campaigns-list">
                <div>
                    <p>LISTAR</p>
                    <button class="ativos">Ativos</button>
                    <button class="concluídos">Concluídos</button>
                </div>
            </div>
            <div class="grid-campaign-actives" style="display: none;">
                <?php foreach ($campaigns as $campaign): ?>
                        <?php if ($campaign['status'] === 'Adquira já!' || $campaign['status'] === 'Corre que está acabando!'): ?>
                    <a href="/campanha/<?php echo htmlspecialchars($campaign['slug']); ?>">
                    <div class="campaign">
                        <div class="picture-campaign" style="background-image: url('/public/images/<?php echo htmlspecialchars($campaign['image_raffle']); ?>')">                            
                        </div>
                        <div class="info-campaign">
                            <h3>
                                <?php echo substr(htmlspecialchars($campaign['name']), 0, 20); ?>
                            </h3>
                            <p>
                                <?php echo substr(htmlspecialchars($campaign['subname']), 0, 36); ?>
                            </p>
                            <span>
                                <?php echo htmlspecialchars($campaign['status']); ?>
                            </span>
                            <?php if (!empty($campaign['draw_date'])): ?>
                            <p class="draw-date">
                                <i class="bi bi-calendar2-check"></i>
                                <?php echo substr(htmlspecialchars($campaign['draw_date']), 0, 5); ?>
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div class="grid-campaign-actives" style="display: none;">
                <?php foreach ($campaigns as $campaign): ?>
                        <?php if ($campaign['status'] === 'Concluído'): ?>
                    <a href="/campanha/<?php echo htmlspecialchars($campaign['slug']); ?>">
                    <div class="campaign">
                        <div class="picture-campaign" style="background-image: url('/public/images/<?php echo htmlspecialchars($campaign['image_raffle']); ?>')">                            
                        </div>
                        <div class="info-campaign">
                            <h3>
                                <?php echo substr(htmlspecialchars($campaign['name']), 0, 20); ?>
                            </h3>
                            <p>
                                <?php echo substr(htmlspecialchars($campaign['subname']), 0, 36); ?>
                            </p>
                            <span style="background-color: #212529; animation: none;">
                                <?php echo htmlspecialchars($campaign['status']); ?>
                            </span>
                            <?php if (!empty($campaign['draw_date'])): ?>
                            <p class="draw-date">
                                <i class="bi bi-calendar2-check"></i>
                                <?php echo substr(htmlspecialchars($campaign['draw_date']), 0, 5); ?>
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <script src="../../public/js/pages/campanhas.js"></script>
<?php include __DIR__ . '/../partials/footer.php'; ?>


