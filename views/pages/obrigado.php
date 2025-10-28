<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<h5 class="title-head" style="display: none;">Compra</h5>

<body>
    <section>
        <div class="back-range" style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;"></div>
        <div class="container">
        <?php if ($order['payment_status'] === 'pago'): ?>
            <div class="status-order-paid ord-status">
                <i class="bi bi-check-circle"></i>
                <h4>Pagamento concluído</h4>
                <p>Agora é só torcer!</p>
            </div>

            <div class="draw-title-winner" style="display: none;">
                <?php 
                $numbersArray = explode(', ', $order['numbers']); 
                $drawTitles = explode(', ', $order['campaign_draw_titles']);
                $awardTitles = explode(', ', $order['campaign_award_titles']);
                $winningNumbers = array_intersect($numbersArray, $drawTitles);
                $winningCount = count($winningNumbers);

                if ($winningCount > 0) {
                    echo '<script>document.querySelector(".draw-title-winner").style.display = "block";</script>';
                }
                ?>

                <div class="congratulation">
                    <h4>✨ Parabéns!</h4>
                    <h5>Sua compra possui <strong><span class="qtd-titles"><?php echo $winningCount; ?></span> título(s) contemplado(s)</strong> na modalidade Premiação instantânea:</h5>

                    <div class="numbers-contemplated">
                        <?php foreach ($winningNumbers as $winningNumber): ?>
                            <div style="display: flex; align-items: center; gap: 15px; justify-content: center;padding-bottom: 10px;">
                            <button><?php echo htmlspecialchars($winningNumber); ?></button>
                            <h6>
                                <?php 
                                $index = array_search($winningNumber, $drawTitles);
                                echo htmlspecialchars($awardTitles[$index]); 
                                ?>
                            </h6>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <p style="padding-top: 0;">Em breve, nossa equipe entrará em contato com você para realizar a entrega do prêmio!</p>
                    <a href="https://wa.me/55<?php echo htmlspecialchars($settings['support_wpp']); ?>" target="_blank">
                        <button><i class="bi bi-whatsapp"></i> Falar com o suporte</button>
                    </a>
                </div>
            </div>

            <div class="order-info">
                <h4><i class="bi bi-info-circle"> Detalhes da sua compra</i></h4>
                <p><strong>ID do pedido: </strong>#<?php echo htmlspecialchars($order['hash_order'] ?? ''); ?></p>
                <p><strong>Nome: </strong><?php echo htmlspecialchars($order['user_name'] ?? ''); ?></p>
                <p><strong>Telefone: </strong><?php echo substr(htmlspecialchars($order['user_phone'] ?? ''), 0, 9); ?>-****</p>
                <p><strong>Data/Horário: </strong><?php echo date('d/m/y \à\s H:i', strtotime(htmlspecialchars($order['updated_at'] ?? ''))); ?> </p>

                <p><strong>Quantidade: </strong><?php echo htmlspecialchars($order['quantity'] ?? ''); ?> </p>

                <p><strong>Total: </strong>R$ <?php echo number_format(floatval($order['total'] ?? 0), 2, ',', '.'); ?></p>

                <p style="border-bottom: none;"><strong>Títulos: </strong></p>
                <div class="list-numbers">
                    <?php foreach ($numbersArray as $number): ?>
                        <button><?php echo htmlspecialchars(trim($number)); ?></button>
                    <?php endforeach; ?>
                </div>
            </div>
            <a href="/contato" class="contact-payment">Problemas com sua compra? <strong>clique aqui</strong>.</a>
        <?php endif; ?>
        </div>
    </section>
    <script src="../../public/js/pages/orderDetails.js"></script>
    <?php
        $total = str_replace(',', '.', $order['total']);
        $totalFloat = floatval($total);
        ?>

    <script>
    fbq('track', 'Purchase', {
        content_name: '<?php echo htmlspecialchars($order['campaign_name']); ?>',
        content_ids: ['<?php echo htmlspecialchars($order['campaign_id']); ?>'],
        content_type: 'product',
        value: <?php echo htmlspecialchars($totalFloat); ?>,
        currency: 'BRL',
        contents: [{
            id: '<?php echo htmlspecialchars($order['campaign_id']); ?>',
            quantity: <?php echo htmlspecialchars($order['quantity']); ?>
        }],
        num_items: <?php echo htmlspecialchars($order['quantity']); ?>,
        payment_method: 'pix',
        status: 'completed'
    });
    </script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
