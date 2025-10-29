<?php include __DIR__ . '/../partials/header.php'; ?>
<h5 class="title-head" style="display: none;">Home</h5>

<body style="max-width: 1300px; margin: auto; background-color: #f5f5f5;">
<?php include __DIR__ . '/../partials/dashboard/sidebar.php'; ?>
    <section class="dashboard-container" style="padding-left: 65px;">
        <div class="dashboard-home">
            <h1>Dashboard</h1>
            <div class="services-dashboard-home">
                <div class="services">
                    <span>
                        <i class="bi bi-megaphone" style="background-color: #006d4e2d; color: #006d4e;"></i>
                    </span>
                    <span>
                        <h4>Campanhas</h4>
                        <p><?php echo htmlspecialchars($data['totalCampaigns'] ?? 0, ENT_QUOTES, 'UTF-8'); ?></p>
                    </span>
                </div>

                <div class="services">
                    <span>
                        <i class="bi bi-people" style="background-color: #a72d0046; color: #a72c00;"></i>
                    </span>
                    <span>
                        <h4>Usuários</h4>
                        <p><?php echo htmlspecialchars($data['totalUsers'] ?? 0, ENT_QUOTES, 'UTF-8'); ?></p>
                    </span>
                </div>

                <div class="services">
                    <span>
                        <i class="bi bi-bag-check" style="background-color: #04396b3d; color: #04396b;"></i>
                    </span>
                    <span>
                        <h4>Pedidos</h4>
                        <p><?php echo htmlspecialchars($data['totalOrders'] ?? 0, ENT_QUOTES, 'UTF-8'); ?></p>
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
                            <input type="password" id="revenue-input" value="<?php echo htmlspecialchars(number_format($data['totalRevenue'] ?? 0, 2, ',', '.'), ENT_QUOTES, 'UTF-8'); ?>">
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </section>
    <script src="../../public/js/dashboard/home.js"></script>
</body>
