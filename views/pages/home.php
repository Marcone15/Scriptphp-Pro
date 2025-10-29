<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<h5 class="title-head" style="display: none;">Início</h5>

<body>
    <section>
        <div class="back-range" style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;"></div>
        <div class="container">
            <span class="title">
                <h1>⚡ Campanhas</h1>
                <p>Escolha sua sorte</p>
            </span>
            <?php foreach ($campaigns as $campaign): ?>
                <?php if ($campaign['favorite']): ?>
                <a href="/campanha/<?php echo htmlspecialchars($campaign['slug']); ?>">
                    <div class="favorite-campaign">
                        <div class="img-campaign" style="background-image: url('/public/images/<?php echo htmlspecialchars($campaign['image_raffle']); ?>')"></div>
                        <span>
                            <?php echo htmlspecialchars($campaign['status']); ?>
                        </span>
                        <h2>
                            <?php echo substr(htmlspecialchars($campaign['name']), 0, 27); ?>
                        </h2>
                        <p>
                            <?php echo substr(htmlspecialchars($campaign['subname']), 0, 39); ?>
                        </p>
                    </div>
                </a>
                <?php endif; ?>
            <?php endforeach; ?>

            <div class="grid-campaign-actives">
                <?php 
                $count = 0;
                foreach ($campaigns as $campaign): 
                    if ($count >= 20) break;
                    if (!$campaign['favorite'] && ($campaign['status'] === 'Adquira já!' || $campaign['status'] === 'Corre que está acabando!')): 
                        $count++; ?>
                        <a href="/campanha/<?php echo htmlspecialchars($campaign['slug']); ?>">
                        <div class="campaign">
                            <div class="picture-campaign" style="background-image: url('/public/images/<?php echo htmlspecialchars($campaign['image_raffle']); ?>')">                            
                            </div>
                            <div class="info-campaign">
                                <h3><?php echo substr(htmlspecialchars($campaign['name']), 0, 20); ?></h3>
                                <p><?php echo substr(htmlspecialchars($campaign['subname']), 0, 36); ?></p>
                                <span><?php echo htmlspecialchars($campaign['status']); ?></span>
                                
                                <?php if (!empty($campaign['draw_date'])): ?>
                                <p class="draw-date">
                                    <i class="bi bi-calendar2-check"></i>
                                    <?php echo substr(htmlspecialchars($campaign['draw_date']), 0, 5); ?>
                                </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        </a>
                    <?php endif;
                endforeach; ?>
            </div>

            <div class="grid-campaign-actives">
                <?php 
                $count = 0;
                foreach ($campaigns as $campaign): 
                    if ($count >= 20) break;
                    if (!$campaign['favorite'] && $campaign['status'] === 'Concluído'): 
                        $count++; ?>
                        <a href="/campanha/<?php echo htmlspecialchars($campaign['slug']); ?>">
                        <div class="campaign">
                            <div class="picture-campaign" style="background-image: url('/public/images/<?php echo htmlspecialchars($campaign['image_raffle']); ?>')">                            
                            </div>
                            <div class="info-campaign">
                                <h3><?php echo substr(htmlspecialchars($campaign['name']), 0, 20); ?></h3>
                                <p><?php echo substr(htmlspecialchars($campaign['subname']), 0, 36); ?></p>
                                <span style="background-color: #212529; animation: none;"><?php echo htmlspecialchars($campaign['status']); ?></span>
                                
                                <?php if (!empty($campaign['draw_date'])): ?>
                                <p class="draw-date">
                                    <i class="bi bi-calendar2-check"></i>
                                    <?php echo substr(htmlspecialchars($campaign['draw_date']), 0, 5); ?>
                                </p>
                                <?php endif; ?>

                            </div>
                        </div>
                        </a>
                    <?php endif;
                endforeach; ?>
            </div>


            <div class="btn-support">
                <a href="/contato">
                    <span>🤷</span>
                    <div>
                        <h3>Dúvidas</h3>
                        <p>Fale conosco</p>
                    </div>
                </a>
            </div>

            <div class="winners">
                <span class="title-winners">
                    <h3>🎉 Ganhadores</h3>
                    <p>sortudos</p>
                </span>
                <div class="grid-winner">
                <?php $count = 0; 
                foreach ($campaigns as $campaign): 
                    if ($count >= 20) break; 
                    if ($campaign['status'] === 'Concluído'):
                    $winner = isset($campaign['winner']) ? explode(', ', $campaign['winner']) : []; ?>
                    <a href="/campanha/<?php echo htmlspecialchars($campaign['slug']); ?>">
                        <div class="grid-winners">
                            
                            <div class="img-user-home" style="background-image: url('../../public/images/<?php echo htmlspecialchars($winner[0], ENT_QUOTES, 'UTF-8'); ?>')"></div>
                            
                            <div class="info-winner-home">
                                <p><?php echo substr(htmlspecialchars($winner[1], ENT_QUOTES, 'UTF-8'), 0, 15 ); ?></p>

                                <h3><?php echo substr(htmlspecialchars($campaign['name']), 0, 20); ?></h3>

                                <p>Número da sorte: <strong><?php echo htmlspecialchars($winner[2], ENT_QUOTES, 'UTF-8'); ?></strong></p>

                                <p>Data da premiação: <strong><span><?php echo htmlspecialchars($winner[3], ENT_QUOTES, 'UTF-8'); ?></span></strong></p>

                            </div>
                        </div>
                    </a>
                    <?php endif; ?>
                <?php endforeach; ?>                        
                </div>
            </div>

            <div class="faq">
                <div class="title-faq">
                        <h2>🤷 Perguntas frequentes</h2>
                </div>
                <div class="container-faq">
                    <h4 class="faq-1">
                        <i class="bi bi-arrow-right"></i>
                        Acessando suas compras
                    </h4>
                    <p class="response-1">
                    Existem duas formas de você conseguir acessar suas compras, a primeira é logando no site, abrindo o menu do site e clicando em "Entrar" e a segunda forma é visitando a campanha e clicando em "Meus títulos" logo a baixo do nome da campanha.
                    </p>
                </div>

                <div class="container-faq">
                    <h4 class="faq-2">
                        <i class="bi bi-arrow-right"></i>
                        Como é o processo do sorteio?
                    </h4>
                    <p class="response-2">
                    O sorteio será realizado com base na extração da Loteria Federal, conforme Condições de Participação constantes no título.
                    </p>
                </div>

                <div class="container-faq">
                    <h4 class="faq-3">
                        <i class="bi bi-arrow-right"></i>
                        Onde o prêmio será entregue?
                    </h4>
                    <p class="response-3">
                    Não há necessidade de se preocupar com os trâmites relacionados à entrega do prêmio, pois nós cuidaremos de tudo.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <script src="../../public/js/pages/home.js"></script>
<?php include __DIR__ . '/../partials/footer.php'; ?>




