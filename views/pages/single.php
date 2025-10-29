<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<h5 class="title-head" style="display: none;"><?php echo strtoupper(htmlspecialchars($campaign['name'])); ?>
</h5>

<body>
    <section>
        <div class="back-range" style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;"></div>
        <div class="container">
            <div class="info-single" data-image-raffle="<?php echo htmlspecialchars($campaign['image_raffle']); ?>" data-image-raffle-galery="<?php echo htmlspecialchars($campaign['image_raffle_galery']); ?>">
                <i class="bi bi-chevron-left slide-control" id="prevSlide"></i>
                <div class="img-single" id="imgSingle" style="background-image: url('../../public/images/<?php echo htmlspecialchars($campaign['image_raffle']); ?>')"></div>
                <i class="bi bi-chevron-right slide-control" id="nextSlide"></i>
                <div class="background-gradient">
                    <?php if ($campaign['status'] !== 'Concluído'): ?>
                    <span>
                        <?php echo htmlspecialchars($campaign['status']); ?>
                    </span>
                    <?php else: ?>
                        <span style="animation: none; background-color: #212529">
                        <?php echo htmlspecialchars($campaign['status']); ?>
                        </span>
                    <?php endif; ?>
                    <h3>
                        <?php echo substr(htmlspecialchars($campaign['name']), 0, 27); ?>
                    </h3>
                    <p>
                        <?php echo substr(htmlspecialchars($campaign['subname']), 0, 39); ?>
                    </p>
                </div>
                <a href="/meus-numeros">
                    <button>
                        <i class="bi bi-cart"></i> Meus títulos
                    </button>
                </a>
            </div>

            <div class="date-price">
                <?php if ($campaign['draw_date']): ?>
                <span class="date-single">
                    <p>Sorteio </p>
                    <span>
                        <?php echo htmlspecialchars($campaign['draw_date']); ?>
                    </span>
                </span>
                <?php endif; ?>
                <span class="price-single">
                    <p>Por apenas </p>
                    <div style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;">
                        R$
                        <span class="price-value">
                            <?php 
                            $priceString = str_replace(',', '.', $campaign['price']); 
                            $price = floatval($priceString);
                            if ($price >= 1 && floor($price) == $price) { 
                                $priceFormatted = number_format($price, 2, ',', '.');
                                echo htmlspecialchars($priceFormatted);
                            } else {
                                echo htmlspecialchars(number_format($price, 2, ',', '.')); 
                            }
                            ?>
                         </span>
                    </div>
                </span>
            </div>
            
            <?php if ($campaign['status'] === 'Concluído'): ?>
                <div class="winner-single">
                    <?php
                    $winner = isset($campaign['winner']) ? explode(', ', $campaign['winner']) : [];
                    if (count($winner) >= 2): ?>
                        <div class="img-user-winner" style="background-image: url('../../public/images/<?php echo htmlspecialchars($winner[0], ENT_QUOTES, 'UTF-8'); ?>')">
                        </div>
                        <div class="info-winner-single">
                            <h3><?php echo substr(htmlspecialchars($winner[1], ENT_QUOTES, 'UTF-8'), 0, 15 ); ?><i class="bi bi-check-circle"></i></h3>
                            <p>Ganhador(a) com o número da sorte <strong><?php echo htmlspecialchars($winner[2], ENT_QUOTES, 'UTF-8'); ?></strong></p>
                        </div>
                    <?php else: ?>
                        <div class="info-winner-single">
                            <h3>Informação de ganhador(a) não disponível</h3>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($campaign['status'] !== 'Concluído'): ?>
                <?php if (intval($numbersSoldPercentage) !== 100 && $campaign['status'] !== 'Concluído'): ?>
                <?php if ($campaign['progress_bar']): ?>
                    <div class="progress-bar">
                        <div class="progress_inner" style="width: <?php echo floor($numbersSoldPercentage); ?>%;">
                            <p><?php echo floor($numbersSoldPercentage); ?>%</p>
                        </div>
                    </div>

                <?php endif; ?>

                <?php if ($campaign['qtd_promo'] && $campaign['price_promo']): ?>
                    <?php include __DIR__ . '/../partials/promotions.php'; ?>
                <?php endif; ?>

                <?php if ($campaign['type_raffle'] === 'Automática'): ?>
                    <?php include __DIR__ . '/../partials/automatic.php'; ?>
                <?php endif; ?>

                <div class="description-single">
                    <button class="btn-Description"><i class="bi bi-arrow-down-square-fill"></i>Descrição/Regulamento</button>
                    <div class="description" style="display: none">
                        <?php echo htmlspecialchars_decode($campaign['description']); ?>
                    </div>
                </div>

                <?php if ($campaign['ranking']): ?>
                    <?php include __DIR__ . '/../partials/ranking.php'; ?>
                <?php endif; ?>

                <?php if ($campaign['ranking_diary']): ?>
                    <?php include __DIR__ . '/../partials/rankingdiary.php'; ?>
                <?php endif; ?>

                <?php if ($campaign['type_raffle'] === 'Normal'): ?>
                    <?php include __DIR__ . '/../partials/normal.php'; ?>
                <?php endif; ?>

                <?php if ($campaign['type_raffle'] === 'Fazendinha'): ?>
                    <?php include __DIR__ . '/../partials/animals.php'; ?>
                <?php endif; ?>

                <?php if ($campaign['type_raffle'] === 'Automática'): ?>
                    <?php if ($campaign['bigger_smaller_title']): ?>
                        <?php include __DIR__ . '/../partials/biggersmaller.php'; ?>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($campaign['type_raffle'] === 'Automática'): ?>
                    <?php if ($campaign['bigger_smaller_title_diary']): ?>
                        <?php include __DIR__ . '/../partials/biggersmallerdiary.php'; ?>
                    <?php endif; ?>
                <?php endif; ?>


                <?php if ($campaign['draw_titles'] && $campaign['award_titles']): ?>
                    <?php include __DIR__ . '/../partials/drawtitles.php'; ?>
                <?php endif; ?>


                <?php include __DIR__ . '/../partials/paymentmodal.php'; ?>

                <?php if ($campaign['type_raffle'] !== 'Fazendinha'): ?>
                    <?php include __DIR__ . '/../partials/socials.php'; ?>
                <?php endif; ?>

                <?php else: ?>
                <div class="numbersRest" style="color: #664d03; font-weight: 300; font-size: .8em; background-color: #fff3cd; border: solid 1px #ffe69c; border-radius: 7px; box-shadow: none; padding: 7px; margin-top: 7px;">
                    <p>Todos os títulos já foram vendidos ou reservados.</p>
                </div>
                <?php endif; ?>
            <?php endif; ?>

        </div>
         <?php include __DIR__ . '/../partials/socialsicons.php'; ?>

    </section>
    <script src="../../public/js/pages/single.js"></script>
    

<?php include __DIR__ . '/../partials/footer.php'; ?>

  
