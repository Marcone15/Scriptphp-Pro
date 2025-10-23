<?php include __DIR__ . '/../partials/header.php'; ?>
<h5 class="title-head" style="display: none;">Ranking</h5>

<body style="max-width: 1300px; margin: auto; background-color: #f5f5f5;">
<?php include __DIR__ . '/../partials/dashboard/sidebar.php'; ?>
    <section class="dashboard-container" style="padding-left: 65px;">
        <div class="dashboard-ranking">
            <h1>Ranking</h1>
            <div class="filter-ranking">
                <form method="GET" action="/dashboard/ranking">
                    <select name="campaign_id">
                        <?php foreach ($campaigns as $campaign): ?>
                            <option value="<?php echo htmlspecialchars($campaign['id'], ENT_QUOTES, 'UTF-8'); ?>" <?php echo isset($_GET['campaign_id']) && $_GET['campaign_id'] == $campaign['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($campaign['name'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <select name="category_ranking">
                        <option value="Geral" <?php echo $category === 'Geral' ? 'selected' : ''; ?>>Geral</option>
                        <option value="Diário" <?php echo $category === 'Diário' ? 'selected' : ''; ?>>Diário</option>
                    </select>

                    <button type="submit">Filtrar</button>
                </form>
            </div>
            
            <div class="table-names-ranking">
                <div style="width: 35%">CLIENTE</div>
                <div style="width: 12%">TELEFONE</div>
                <div style="width: 12%">QTD. NÚMEROS</div>
                <div style="width: 12%">CATEGORIA</div>
            </div>
            
            <?php if (isset($topBuyers[0]['name']) || isset($topBuyers[1]['name']) || isset($topBuyers[2]['name'])): ?>
            <div class="ranking-grid">
                <div class="client-ranking">
                    <h4>🥇</h4>
                    <div style="background-image: url('../../public/images/<?php echo isset($topBuyers[0]['image_user']) ? htmlspecialchars($topBuyers[0]['image_user'], ENT_QUOTES, 'UTF-8') : ' '; ?>');"></div>
                    <p><?php echo isset($topBuyers[0]['name']) ? htmlspecialchars($topBuyers[0]['name'], ENT_QUOTES, 'UTF-8') : ' '; ?></p>
                </div>

                <div class="phone-ranking">
                    <p><?php echo isset($topBuyers[0]['phone']) ? htmlspecialchars($topBuyers[0]['phone'], ENT_QUOTES, 'UTF-8') : ' '; ?></p>
                </div>

                <div class="qtd-numbers-ranking">
                    <p><?php echo isset($topBuyers[0]['total_quantity']) ? htmlspecialchars($topBuyers[0]['total_quantity'], ENT_QUOTES, 'UTF-8') : '0'; ?> Títulos</p>
                </div>

                <div class="category-ranking">
                    <p><?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div> 
            
            
            <div class="ranking-grid">
                <div class="client-ranking">
                    <h4>🥈</h4>
                    <div style="background-image: url('../../public/images/<?php echo isset($topBuyers[1]['image_user']) ? htmlspecialchars($topBuyers[1]['image_user'], ENT_QUOTES, 'UTF-8') : ' '; ?>');"></div>
                    <p><?php echo isset($topBuyers[1]['name']) ? htmlspecialchars($topBuyers[1]['name'], ENT_QUOTES, 'UTF-8') : ' '; ?></p>
                </div>

                <div class="phone-ranking">
                    <p><?php echo isset($topBuyers[1]['phone']) ? htmlspecialchars($topBuyers[1]['phone'], ENT_QUOTES, 'UTF-8') : ' '; ?></p>
                </div>

                <div class="qtd-numbers-ranking">
                    <p><?php echo isset($topBuyers[1]['total_quantity']) ? htmlspecialchars($topBuyers[1]['total_quantity'], ENT_QUOTES, 'UTF-8') : '0'; ?> Títulos</p>
                </div>

                <div class="category-ranking">
                    <p><?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div> 

            <div class="ranking-grid">
                <div class="client-ranking">
                    <h4>🥉</h4>
                    <div style="background-image: url('../../public/images/<?php echo isset($topBuyers[2]['image_user']) ? htmlspecialchars($topBuyers[2]['image_user'], ENT_QUOTES, 'UTF-8') : ' '; ?>');"></div>
                    <p><?php echo isset($topBuyers[2]['name']) ? htmlspecialchars($topBuyers[2]['name'], ENT_QUOTES, 'UTF-8') : ' '; ?></p>
                </div>

                <div class="phone-ranking">
                    <p><?php echo isset($topBuyers[2]['phone']) ? htmlspecialchars($topBuyers[2]['phone'], ENT_QUOTES, 'UTF-8') : ' '; ?></p>
                </div>

                <div class="qtd-numbers-ranking">
                    <p><?php echo isset($topBuyers[2]['total_quantity']) ? htmlspecialchars($topBuyers[2]['total_quantity'], ENT_QUOTES, 'UTF-8') : '0'; ?> Títulos</p>
                </div>

                <div class="category-ranking">
                    <p><?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </section>
</body>
