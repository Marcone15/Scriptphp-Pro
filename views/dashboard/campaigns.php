<?php include __DIR__ . '/../partials/header.php'; ?>
<h5 class="title-head" style="display: none;">Campanhas</h5>


<body style="max-width: 1300px; margin: auto; background-color: #f5f5f5;">
<?php include __DIR__ . '/../partials/dashboard/sidebar.php'; ?>

    <section class="dashboard-container" style="padding-left: 65px;">
        <div class="dashboard-campaigns">
            <h1>Campanhas</h1>
            <div class="campaigns-container">
                <div class="filter-campaigns">
                    <form method="GET" action="/dashboard/campaigns">
                        <select name="status" id="">
                            <option value="Todas">Todas</option>
                            <option value="Ativo">Ativas</option>
                            <option value="Concluído">Concluídas</option>
                        </select>
                        <button type="submit">Filtrar</button>
                    </form>
                </div>
                <div class="table-names-campaigns">
                    <div style="width: 25%">CAMPANHAS</div>
                    <div style="width: 10%">TIPO</div>
                    <div style="width: 8%">VALOR</div>
                    <div style="width: 24%">QTD. NÚMEROS</div>
                    <div style="width: 10%">STATUS</div>
                    <div style="width: 12%">DATA</div>
                    <div style="width: 13%">AÇÃO</div>
                </div>
                <div class="campaigns-list">
                    <?php foreach ($campaigns as $campaign): ?>
                    <div class="campaigns-grid">
                        <div class="campaign">
                            <div class="img-campaign" style="background-image: url('../../public/images/<?php echo htmlspecialchars($campaign['image_raffle'], ENT_QUOTES, 'UTF-8'); ?>')"></div>
                            <p><?php echo substr(htmlspecialchars($campaign['name'], ENT_QUOTES, 'UTF-8'), 0, 25); ?>...</p>
                        </div>

                        <div class="type-campaign">
                            <p><?php echo htmlspecialchars($campaign['type_raffle'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>

                        <div class="price-campaign">
                            <p>R$ <?php echo number_format((float) str_replace(',', '.', $campaign['price']), 2, ',', '.'); ?></p>
                        </div>

                        <div class="qtd-nubers-campaign">
                            <div class="progress-bar">
                                <div class="progress-bar-inner" style="width: <?php echo htmlspecialchars($campaign['percentage_sold'], ENT_QUOTES, 'UTF-8'); ?>%;"></div>
                            </div>
                            <p><?php echo htmlspecialchars($campaign['percentage_sold'], ENT_QUOTES, 'UTF-8'); ?>% de <?php echo number_format((int) $campaign['qtd_numbers'], 0, '', '.'); ?> vendidos</p>
                        </div>

                        <div class="status-campaign">
                            <?php if ($campaign['status'] === 'Concluído'): ?>
                                <p style="background-color: #212529; color: #fff;">
                                    Concluído
                                </p>
                            <?php else: ?>
                                <p>
                                    <?php 
                                        $status = htmlspecialchars($campaign['status'], ENT_QUOTES, 'UTF-8');
                                        echo ($status === 'Adquira já!' || $status === 'Corre que está acabando!') ? 'Ativo' : $status;
                                    ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div class="date-campaign">
                            <p>
                                <?php 
                                    $createdAt = new DateTime(htmlspecialchars($campaign['created_at'], ENT_QUOTES, 'UTF-8'));
                                    echo $createdAt->format('d/m/y \à\s H:i');
                                ?>
                            </p>
                        </div>

                        <div class="action-campaign">
                            <a href="/campanha/<?php echo ($campaign['slug']); ?>" target="_blank"><i class="bi bi-eye"></i></a>
                            <a href="/dashboard/campaign/edit-<?php echo ($campaign['id']); ?>"><i class="bi bi-pencil"></i></i></a>

                            <form action="/dashboard/delete-campaign" method="post" class="form-delete-campaign">
                                <input type="hidden" value="<?php echo ($campaign['id']); ?>" name="id">
                                <button type="button"><i class="bi bi-trash3"></i></button>
                                <div class="modal-delete-campaign" style="display: none;">
                                    <div class="container-modal-delete-campaign">
                                        <h4>Confirme</h4>
                                        <p>Deseja realmente apagar essa campanha?</p>
                                        <span>
                                            <button type="button" class="delete-campaign-no">Não</button>
                                            <button type="button" class="delete-campaign-yes">Sim</button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                            
                            <i class="bi bi-trophy"></i>
                            <div class="modal-define-winner" style="display: none;">
                                <div class="container-modal-define-winner">
                                    <form method="post" action="" class="form-search-winner">
                                        <h4>Definir ganhador</h4>
                                        <label>Informe o título do ganhador</label>
                                        <span>
                                            <input type="text" name="title-number" required>
                                            <button type="submit"><i class="bi bi-check-circle"></i></button>
                                        </span>
                                    </form> 
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button id="show-more">Mostrar mais</button>
            </div>
        </div>
    </section>
    <script src="../../public/js/dashboard/campaigns.js"></script>
</body>
