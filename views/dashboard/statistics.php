<?php include __DIR__ . '/../partials/header.php'; ?>
<h5 class="title-head" style="display: none;">Estatíticas</h5>

<body style="max-width: 1300px; margin: auto; background-color: #f5f5f5;">
<?php include __DIR__ . '/../partials/dashboard/sidebar.php'; ?>
    <section class="dashboard-container" style="padding-left: 65px;">
        <div class="dashboard-home">
            <h1>Relatórios</h1>
            <div class="filter-statistic">
                <form method="GET" action="/dashboard/statistics">
                    <select name="campaign_id">
                        <option value="">Todas</option>
                        <?php foreach ($campaigns as $campaign): ?>
                            <option value="<?php echo htmlspecialchars($campaign['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($campaign['name'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Filtrar</button>
                </form>
            </div>
            <div class="services-dashboard-home">
                <div class="services">
                    <span>
                        <i class="bi bi-people" style="background-color: #a72d0046; color: #a72c00;"></i>
                    </span>
                    <span>
                        <h4>Participantes</h4>
                        <p><?php echo htmlspecialchars($participants, ENT_QUOTES, 'UTF-8'); ?></p>
                    </span>
                </div>

                <div class="services">
                    <span>
                        <i class="bi bi-bag-check" style="background-color: #04396b3d; color: #04396b;"></i>
                    </span>
                    <span>
                        <h4>Pedidos</h4>
                        <p><?php echo htmlspecialchars($orders, ENT_QUOTES, 'UTF-8'); ?></p>
                    </span>
                </div>

                <div class="services">
                    <span>
                        <i class="bi bi-graph-up-arrow" style="background-color: #04396b3d; color: #04396b;"></i>
                    </span>
                    <span>
                        <h4>Títulos vendidos</h4>
                        <p><?php echo htmlspecialchars(number_format($titlesSold ?? 0, 0, ',', '.'), ENT_QUOTES, 'UTF-8'); ?> </p>
                        </span>
                </div>

                <div class="services">
                    <span>
                        <i class="bi bi-wallet2" style="background-color: #006d4e2d; color: #006d4e;"></i>
                    </span>
                    <span>
                        <h4 style="display: flex; align-items: center; margin-bottom: -15px; margin-top: -10px;">Faturamento<i class="bi bi-eye" id="toggle-revenue" style="font-size: 1.3em; cursor: pointer;"></i></h4>
                        <span style="display: flex;">
                            <p>R$ </p>
                            <input type="password" id="revenue-input" value="<?php echo number_format((float) str_replace(',', '.', $totalRevenue), 2, ',', '.'); ?>">
                        </span>
                    </span>
                </div>
            </div>
            <div class="table-names-statistics">
                <div style="width: ">DATA</div>
                <div style="width: ">PARTICIPANTES</div>
                <div style="width: ">PEDIDOS</div>
                <div style="width: ">VENDIDOS</div>
                <div style="width: ">TOTAL</div>
            </div>
            <?php foreach ($dailyStatistics as $statistic): ?>
            <div class="statistic-grid">
                <div class="date-statistic">
                    <p><?php echo date('d/m/y', strtotime($statistic['date'])); ?></p>
                </div>

                <div class="statistics-clients">
                    <p><strong><?php echo htmlspecialchars($statistic['participants'], ENT_QUOTES, 'UTF-8'); ?></strong></p>
                </div>

                <div class="statistics-orders">
                    <p><strong><?php echo htmlspecialchars($statistic['orders'], ENT_QUOTES, 'UTF-8'); ?></strong></p>
                </div>

                <div class="statistics-numbers-sold">
                    <p><strong><?php echo htmlspecialchars($statistic['titles_sold'], ENT_QUOTES, 'UTF-8'); ?></strong></p>
                </div>

                <div class="statistics-total">
                    <p><strong>R$ <?php echo number_format((float) str_replace(',', '.', $statistic['total_revenue']), 2, ',', '.'); ?></strong></p>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </section>
    <script src="../../public/js/dashboard/statistics.js"></script>
</body>
