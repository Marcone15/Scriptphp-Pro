<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<h5 class="title-head" style="display: none;">Meus números</h5>

<body>
    <section>
        <div class="back-range" style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;"></div>
        <div class="container" style="height: max-content;">
            <span class="title">
                <h1>🛒 Meus títulos</h1>
            </span>
            <?php if (isset($searchPerformed) && $searchPerformed): ?>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="grid-results-order" style="
                            <?php if (htmlspecialchars($order['payment_status']) === 'pago'): ?>
                                border-bottom: solid 2px #198754;
                            <?php elseif (htmlspecialchars($order['payment_status']) === 'pendente'): ?>
                                border-bottom: solid 2px #e49022;
                            <?php elseif (htmlspecialchars($order['payment_status']) === 'cancelado'): ?>
                                border-bottom: solid 2px #dc3545;
                            <?php endif; ?>
                        ">
                            <div class="info-order">
                                <div class="result-order-image" style="background-image: url('../../public/images/<?php echo htmlspecialchars($order['campaign_image_raffle']); ?>');">
                                </div>

                                <div class="result-order-info">
                                    <h4>
                                        <?php echo substr(htmlspecialchars($order['campaign_name']), 0, 25); ?>...
                                    </h4>
                                    <span>
                                        #<?php echo htmlspecialchars($order['hash_order']); ?> 
                                        - <?php echo date('d/m/y \à\s H:i', strtotime(htmlspecialchars($order['created_at'] ?? ''))); ?>
                                    </span>
                                    <p>Quantidade: <?php echo htmlspecialchars($order['quantity']); ?></p>
                                    <p>Preço: R$ <?php echo htmlspecialchars($order['total']); ?></p>
                                    <strong class="btn-show-numbers">Clique aqui para ver os números</strong>
                                </div>
                            </div>

                            <div class="result-number-order" style="display: none;">
                                <?php if (htmlspecialchars($order['payment_status']) === 'pago'): ?>
                                <div>
                                    <?php 
                                    $numbers = explode(',', htmlspecialchars($order['numbers']));
                                    foreach ($numbers as $number): ?>
                                        <button>
                                            <?php echo htmlspecialchars($number); ?>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="pagination" style="display: flex; flex-wrap: wrap; gap: 10px;">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?phone=<?php echo htmlspecialchars($phone); ?>&page=<?php echo $i; ?>" <?php if ($i == $currentPage) echo 'class="active"'; ?>>
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>

                <?php else: ?>
                    <p class="message-empty">Nenhum pedido encontrado.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>    
    <script src="../../public/helpers/maskPhone.js"></script>
    <script src="../../public/helpers/maskPhone.js"></script>
    <script src="../../public/js/pages/meusnumeros.js"></script>
<?php include __DIR__ . '/../partials/footer.php'; ?>