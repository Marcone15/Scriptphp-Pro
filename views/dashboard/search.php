<?php include __DIR__ . '/../partials/header.php'; ?>
<h5 class="title-head" style="display: none;">Pesquisar</h5>


<body style="max-width: 1300px; margin: auto; background-color: #f5f5f5;">
<?php include __DIR__ . '/../partials/dashboard/sidebar.php'; ?>

    <section class="dashboard-container" style="padding-left: 65px;">
        <div class="dashboard-search">
            <h1>Pesquisa</h1>
            <div class="search-container">
                <div class="filter-search">
                    <form method="GET" action="/dashboard/search" class="search-title search-form">
                        <h4>BUSCAR POR TÍTULO</h4>
                        <span>
                        <select name="campaign_id">
                            <?php foreach ($campaigns as $campaign): ?>
                                <?php if ($campaign['type_raffle'] !== 'Fazendinha'): ?>
                                    <option value="<?php echo $campaign['id']; ?>"><?php echo htmlspecialchars($campaign['name']); ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                            <input type="text" name="title" placeholder="Número">
                            <button name="search_title" value="true">Buscar</button>
                        </span>
                    </form>

                    <form method="GET" action="/dashboard/search" class="search-title-award search-form">
                        <h4>BUSCAR TÍTULOS PREMIADOS</h4>
                        <span>
                            <select name="campaign_id" class="select-title-award">
                            <?php foreach ($campaigns as $campaign): ?>
                                <?php if ($campaign['type_raffle'] === 'Automática'): ?>
                                    <option value="<?php echo $campaign['id']; ?>"><?php echo htmlspecialchars($campaign['name']); ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            </select>
                            <button name="search_title_award" value="true">Buscar</button>
                        </span>
                    </form>

                    <form method="GET" action="/dashboard/search" class="search-bigger-smaller-title">
                        <h4>BUSCAR POR MAIOR E MENOR TÍTULO</h4>
                        <span>
                            <select name="campaign_id">
                            <?php foreach ($campaigns as $campaign): ?>
                                <?php if ($campaign['type_raffle'] === 'Automática'): ?>
                                    <option value="<?php echo $campaign['id']; ?>"><?php echo htmlspecialchars($campaign['name']); ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            </select>

                            <select name="type">
                                <option value="Geral">Geral</option>
                                <option value="Diário">Diário</option>
                            </select>

                            <button name="search_bigger_smaller_title" value="true">Buscar</button>
                        </span>
                    </form>
                </div>
                <div class="result-search">
                    <?php if ($result): ?>
                        <?php if (is_array($result)): ?>
                            <div>
                            <?php if (isset($result['Menor título'])): ?>
                                <h4>Menor título:</h4>
                                <p>Título: <span><?php echo htmlspecialchars($result['Menor título']['Título']); ?></span></p>
                                <p>Comprador(a): <?php echo htmlspecialchars($result['Menor título']['Comprador(a)']); ?></p>
                                <p>Telefone: <?php echo htmlspecialchars($result['Menor título']['Telefone']); ?></p>
                                <p>CPF: <?php echo htmlspecialchars($result['Menor título']['CPF']); ?></p>
                                <p>Campanha: <?php echo htmlspecialchars($result['Menor título']['Campanha']); ?></p>
                                <p>ID do pedido: #<?php echo htmlspecialchars($result['Menor título']['ID do pedido']); ?></p>
                                <p>Data da compra: <?php echo htmlspecialchars($result['Menor título']['Data da compra']); ?></p>
                            <?php endif; ?>

                            <?php if (isset($result['Maior título'])): ?>
                                <h4 style="margin-top: 10px;">Maior título:</h4>
                                <p>Título: <span><?php echo htmlspecialchars($result['Maior título']['Título']); ?></span></p>
                                <p>Comprador(a): <?php echo htmlspecialchars($result['Maior título']['Comprador(a)']); ?></p>
                                <p>Telefone: <?php echo htmlspecialchars($result['Maior título']['Telefone']); ?></p>
                                <p>CPF: <?php echo htmlspecialchars($result['Maior título']['CPF']); ?></p>
                                <p>Campanha: <?php echo htmlspecialchars($result['Maior título']['Campanha']); ?></p>
                                <p>ID do pedido: #<?php echo htmlspecialchars($result['Maior título']['ID do pedido']); ?></p>
                                <p>Data da compra: <?php echo htmlspecialchars($result['Maior título']['Data da compra']); ?></p>
                            <?php endif; ?>

                            <?php if (!isset($result['Maior título'])): ?>
                            <?php if (isset($result) && !empty($result)): ?>
                                <h4>Resultado da Busca:</h4>
                                <?php 
                                $results = isset($result['title']) ? [$result] : $result;
                                foreach ($results as $res): 
                                ?>
                                    <p>Título: <span><?php echo isset($res['title']) ? htmlspecialchars($res['title']) : ''; ?></span></p>
                                    <p>Comprador(a): <?php echo isset($res['name']) ? htmlspecialchars($res['name']) : ''; ?></p>
                                    <p>Telefone: <?php echo isset($res['phone']) ? htmlspecialchars($res['phone']) : ''; ?></p>
                                    <p>CPF: <?php echo isset($res['cpf']) ? htmlspecialchars($res['cpf']) : ''; ?></p>
                                    <p>Campanha: <?php echo isset($res['campaign']) ? htmlspecialchars($res['campaign']) : ''; ?></p>
                                    <p>ID do pedido: #<?php echo isset($res['hash_order']) ? htmlspecialchars($res['hash_order']) : ''; ?></p>
                                    <p>Data da compra: 
                                        <?php 
                                        if (isset($res['created_at'])) {
                                            $date3 = new DateTime($res['created_at']);
                                            $formattedDate3 = $date3->format('d/m/y \à\s H:i');
                                            echo htmlspecialchars($formattedDate3);
                                        } 
                                        ?>
                                    </p>
                                    <hr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php endif; ?>



                                <?php if (is_string($result) && $result === 'Nenhum título premiado encontrado'): ?>
                                    <p><?php echo htmlspecialchars($result); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <p><?php echo htmlspecialchars($result); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>


            </div>
        </div>
    </section>

</body>
