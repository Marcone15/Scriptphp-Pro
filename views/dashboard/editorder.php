<?php include __DIR__ . '/../partials/header.php'; ?>
<h5 class="title-head" style="display: none;">Editar pedido</h5>

<body style="max-width: 1300px; margin: auto; background-color: #f5f5f5;">
<?php include __DIR__ . '/../partials/dashboard/sidebar.php'; ?>
<section class="dashboard-container" style="padding-left: 65px;">
    <div class="dashboard-user-detail">
        <h1>Pedido #<?php echo htmlspecialchars($order['hash_order'], ENT_QUOTES, 'UTF-8'); ?></h1>          
        <div class="user-detail-container">

            <div class="table-names-user-detail">
                <div style="width: 5%;">ID</div>
                <div style="width: 10%;">CLIENTE</div>
                <div style="width: 8%;">STATUS</div>
                <div style="width: 8%;">QTD</div>
                <div style="width: 40%;">NÚMEROS</div>
                <div style="width: 7.7%;">AÇÃO</div>
            </div>

            <div class="user-detail-list">
                <div class="id-order-detail">
                    <p>#<?php echo htmlspecialchars($order['hash_order'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>

                <div class="name-order-detail">
                    <p><?php echo substr(htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'), 0, 20); ?></p>
                </div>

                <div class="status-order-detail" style="background-color: 
                    <?php 
                        echo $order['payment_status'] === 'pendente' ? '#c78b3054' : (
                            $order['payment_status'] === 'pago' ? '#006d4e2d' : '#a72d0046'
                        ); 
                    ?>; color: 
                    <?php 
                        echo $order['payment_status'] === 'pendente' ? '#77480a' : (
                            $order['payment_status'] === 'pago' ? '#006d4e' : '#731b15'
                        ); 
                    ?>;">
                    <p><?php echo htmlspecialchars($order['payment_status'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>

                <div class="qtd-order-detail">
                    <p><?php echo htmlspecialchars($order['quantity'], ENT_QUOTES, 'UTF-8'); ?> Títulos</p>
                </div>

                <?php
                $numbers = explode(',', $order['numbers']);
                ?>
                <div class="numbers-order-detail">
                    <?php foreach ($numbers as $number): ?>
                        <button><?php echo htmlspecialchars(trim($number), ENT_QUOTES, 'UTF-8'); ?></button>
                    <?php endforeach; ?>
                </div>

                <div class="action-order-detail">
                <form action="/dashboard/order/confirm-payment" method="post">
                        <button><i class="bi bi-check-circle"></i></button>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['id'], ENT_QUOTES, 'UTF-8'); ?>">

                        <input type="hidden" name="type_raffle" value="<?php echo htmlspecialchars($campaign['type_raffle'], ENT_QUOTES, 'UTF-8'); ?>">

                        <input type="hidden" name="qtd_numbers" value="<?php echo htmlspecialchars($campaign['qtd_numbers'], ENT_QUOTES, 'UTF-8'); ?>">

                        <input type="hidden" name="quantity" value="<?php echo htmlspecialchars($order['quantity'], ENT_QUOTES, 'UTF-8'); ?>">

                        <input type="hidden" name="id_campaign" value="<?php echo htmlspecialchars($order['id_campaign'], ENT_QUOTES, 'UTF-8'); ?>">
                    </form>

                    <form action="/dashboard/order/cancel" method="post">
                        <button><i class="bi bi-x-circle"></i></button>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['id'], ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="modal-delete-order" style="display: none;">
                            <div class="container-modal-delete-order">
                                <h4>Confirme</h4>
                                <p>Deseja realmente cancelar esse pedido?</p>
                                <span>
                                    <button type="button" class="cancel-order-no">Não</button>
                                    <button type="button" class="cancel-order-yes">Sim</button>
                                </span>
                            </div>
                        </div>
                    </form>


                    <button class="print-order"><i class="bi bi-printer"></i></button>
                </div>

            </div>

            </div>
        </div>
    </div>
</section>
<script src="../../public/js/dashboard/editorder.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.bi-printer').forEach((icon, index) => {
        icon.addEventListener('click', (event) => {
            event.preventDefault();

            const printContent = `
                <div class="print-order">
                    <h1>Pedido #<?php echo htmlspecialchars($order['hash_order'], ENT_QUOTES, 'UTF-8'); ?></h1>
                    <p>Cliente: <?php echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p>Telefone: <?php echo htmlspecialchars($user['phone'], ENT_QUOTES, 'UTF-8'); ?></p>

                    <p>Status: <?php echo htmlspecialchars($order['payment_status'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p>Quantidade: <?php echo htmlspecialchars($order['quantity'], ENT_QUOTES, 'UTF-8'); ?> Títulos</p>
                    <p>Data do pedido: <?php echo htmlspecialchars($order['created_at'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p>Total: R$ <?php echo htmlspecialchars($order['total'], ENT_QUOTES, 'UTF-8'); ?></p>


                    <p>Números:</p>
                    <div class="print-numbers">
                        <?php foreach ($numbers as $number): ?>
                            <button style="font-size: .7em;"><?php echo htmlspecialchars(trim($number), ENT_QUOTES, 'UTF-8'); ?></button>
                        <?php endforeach; ?>
                    </div>                </div>
            `;

            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Imprimir Pedido</title>
                        <style>
                            .print-order { font-family: Arial, sans-serif; }
                            .print-order h1 { font-size: 24px; }
                            .print-order p { font-size: 18px; }
                            .print-order .print-numbers { display: flex; flex-wrap: wrap; gap: 5px; }
                            .print-order .print-numbers button { font-size: 18px; padding: 5px 10px; }
                        </style>
                    </head>
                    <body onload="window.print()">
                        ${printContent}
                    </body>
                </html>
            `);
            printWindow.document.close();
        });
    });
});


</script>

</body>

