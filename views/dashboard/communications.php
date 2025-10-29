<?php include __DIR__ . '/../partials/header.php'; ?>
<h5 class="title-head" style="display: none;">Comunicados</h5>

<body style="max-width: 1300px; margin: auto; background-color: #f5f5f5;">
<?php include __DIR__ . '/../partials/dashboard/sidebar.php'; ?>
    <section class="dashboard-container" style="padding-left: 65px;">
        <div class="dashboard-communications">
            <h1>Comunicados</h1>

            <div class="add-communication">
                <form action="/dashboard/add-communication" method="POST">
                    <button>Adicionar comunicado</button>
                    <div style="display: none;" class="add-communication-field">
                        <textarea placeholder="Digite o comunicado" required name="communication"></textarea>
                    </div>
                </form>
            </div>


            <div class="table-names-communications">
                <div style="width: 50%">COMUNICADO</div>
                <div style="width: 38%">DATA</div>
                <div style="width: 8%">AÇÕES</div>
            </div> 
            <?php if (!empty($communications)): ?>
            <?php foreach ($communications as $communication): ?>
            <div class="ranking-grid">
                <div class="communication-dashboard">
                    <?php echo htmlspecialchars($communication['communication'], ENT_QUOTES, 'UTF-8'); ?>
                    <span style="display: none;" class="edit-communication">
                        <form action="/dashboard/update-communication" method="POST">
                            <textarea name="communication" required><?php echo htmlspecialchars($communication['communication'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($communication['id'], ENT_QUOTES, 'UTF-8'); ?>">
                            <button type="submit">Salvar</button>
                        </form>
                    </span>
                </div>

                <div class="date-communication">
                    <p>
                        <?php
                        $date = new DateTime($communication['created_at']);
                        $formattedDate = $date->format('d/m/y \à\s H:i');
                        echo htmlspecialchars($formattedDate, ENT_QUOTES, 'UTF-8');
                        ?>
                    </p>
                </div>

                <div class="action-communications">

                <i class="bi bi-pencil"></i></i>

                <form action="/dashboard/delete-communication" method="post" class="form-delete-communication">
                    <input type="hidden" value="<?php echo htmlspecialchars($communication['id'], ENT_QUOTES, 'UTF-8'); ?>" name="id">
                    <button type="button"><i class="bi bi-trash3"></i></button>
                    <div class="modal-delete-campaign" style="display: none;">
                        <div class="container-modal-delete-campaign">
                            <h4>Confirme</h4>
                            <p>Deseja realmente apagar esse comunicado?</p>
                            <span>
                                <button type="button" class="delete-campaign-no">Não</button>
                                <button type="button" class="delete-campaign-yes">Sim</button>
                            </span>
                        </div>
                    </div>
                </form>

                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
                <p > </p>
            <?php endif; ?>
        </div>
    </section>
    <script src="../../public/js/dashboard/communications.js"></script>
</body>

