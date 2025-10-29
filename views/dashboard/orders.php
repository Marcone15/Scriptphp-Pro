<?php
$orderHash = $orderHash ?? '';
$titleNumber = $titleNumber ?? '';
$clientName = $clientName ?? '';
?>

<?php include __DIR__ . '/../partials/header.php'; ?>
<h5 class="title-head" style="display: none;">Pedidos</h5>

<body style="max-width: 1300px; margin: auto; background-color: #f5f5f5;">
<?php include __DIR__ . '/../partials/dashboard/sidebar.php'; ?>
<section class="dashboard-container" style="padding-left: 65px;">
    <div class="dashboard-order">
        <h1>Pedidos</h1>          
        <div class="orders-container" >
            <div class="filter-orders">
                <form method="GET" action="/dashboard/orders">
                    <select name="campaign_id" id="select-campaign-order">
                        <option value="">Todas</option>
                        <?php foreach ($campaigns as $campaign): ?>
                        <option value="<?php echo htmlspecialchars($campaign['id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($campaign['name'], ENT_QUOTES, 'UTF-8'); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="order_hash" value="<?php echo htmlspecialchars($orderHash, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Pedido" id="pedido">
                    <input type="text" name="title_number" value="<?php echo htmlspecialchars($titleNumber, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Título" id="titulo">
                    <input type="text" name="client_name" value="<?php echo htmlspecialchars($clientName, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Cliente" id="cliente">
                    <button type="submit">Filtrar</button>
                </form>
            </div>

            <div class="table-names-orders">
                <div style="width: 5%">ID</div>
                <div style="width: 15%">CAMPANHA</div>
                <div style="width: 15%">CLIENTE</div>
                <div style="width: 10%">QTD</div>
                <div style="width: 5%">TOTAL</div>
                <div style="width: 11%">DATA</div>
                <div style="width: 7.1%">STATUS</div>
                <div style="width: 6.5%">AÇÃO</div>
            </div>

            <div class="orders-list">
                <?php foreach ($orders as $order): ?>
                    <div class="order-grid">
                        <div class="id">
                            <p>#<?php echo htmlspecialchars($order['hash_order'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>

                        <div class="campaign">
                            <p><?php echo substr(htmlspecialchars($order['campaign_name'], ENT_QUOTES, 'UTF-8'), 0, 18); ?>...</p>
                        </div>

                        <div class="user">
                            <p><?php echo substr(htmlspecialchars($order['user_name'], ENT_QUOTES, 'UTF-8'), 0, 15); ?>...</p>
                        </div>

                        <div class="qtd-order">
                            <p><?php echo htmlspecialchars($order['quantity'], ENT_QUOTES, 'UTF-8'); ?> Títulos</p>
                        </div>

                        <div class="total-order">
                            <p>R$ <?php echo number_format((float) str_replace(',', '.', $order['total']), 2, ',', '.'); ?></p>
                        </div>

                        <div class="date-order">
                            <p><?php echo date('d/m/y \à\s H:i', strtotime($order['created_at'])); ?></p>
                        </div>

                        <div class="status-order" style="background-color: 
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

                        <div class="actions-order">
                            <a href="/dashboard/order/edit-<?php echo htmlspecialchars($order['id'], ENT_QUOTES, 'UTF-8'); ?>"><i class="bi-pencil"></i></a>
                            
                            <form action="/" method="post" class="form-delete-order">
                                <input type="hidden" value="<?php echo ($order['id']); ?>" name="id">
                                <button type="button"><i class="bi bi-trash3"></i></button>
                                <div class="modal-delete-order" style="display: none;">
                                    <div class="container-modal-delete-order">
                                        <h4>Confirme</h4>
                                        <p>Deseja realmente apagar esse pedido?</p>
                                        <span>
                                            <button type="button" class="delete-order-no">Não</button>
                                            <button type="button" class="delete-order-yes">Sim</button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="pagination" style="display: flex; flex-wrap: wrap; gap: 5px;">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'] . '?&page=' . $i); ?>" class="<?php echo ($i == $currentPage) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>

            </div>
        </div>
    </div>
</section>
<script src="../../public/js/dashboard/orders.js"></script>
</body>
