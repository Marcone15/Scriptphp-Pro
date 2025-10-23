<?php include __DIR__ . '/../partials/header.php'; ?>
<h5 class="title-head" style="display: none;">Usuários</h5>

<body style="max-width: 1300px; margin: auto; background-color: #f5f5f5;">
<?php include __DIR__ . '/../partials/dashboard/sidebar.php'; ?>

    <section class="dashboard-container" style="padding-left: 65px;">
        <div class="dashboard-users">
            <h1>Usuários</h1>
            <div class="users-container">
                <div class="filter-users">
                    <form method="GET" action="/dashboard/users">
                        <input type="text" placeholder="Pesquisar por nome" name="name" value="<?php echo htmlspecialchars($_GET['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="text" placeholder="Pesquisar por telefone" name="phone" value="<?php echo htmlspecialchars($_GET['phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" id="phone">
                        <input type="text" placeholder="Pesquisar por CPF" name="cpf" value="<?php echo htmlspecialchars($_GET['cpf'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" id="cpf">
                        <button type="submit">Filtrar</button>
                    </form>
                </div>

                <div class="table-names-users">
                    <div style="width: 25%">NOME</div>
                    <div style="width: 15%">TELEFONE</div>
                    <div style="width: 5%">FUNÇÃO</div>
                    <div style="width: 15%">DATA DE CADASTRO</div>
                    <div style="width: 7%">AÇÃO</div>
                </div>
                <div class="users-list">
                    <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <div class="user-grid">
                            <div class="name-user">
                                <div style="background-image: url('../../public/images/<?php echo htmlspecialchars($user['image_user'], ENT_QUOTES, 'UTF-8'); ?>');"></div>
                                <p><?php echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>

                            <div class="phone-user">
                                <input type="password" value="<?php echo htmlspecialchars(($user['phone']), ENT_QUOTES, 'UTF-8'); ?>">
                                <i class="bi bi-eye"></i>
                            </div>

                            <div class="function-user">
                                <?php if ($user['isAdmin']): ?>
                                    <p>Administrador</p>
                                <?php else: ?>
                                    <p>Cliente</p>
                                <?php endif; ?>
                            </div>

                            <div class="date-create-user">
                                <p>
                                    <?php
                                    $date = new DateTime($user['created_at']);
                                    $formattedDate = $date->format('d/m/y \à\s H:i');
                                    echo htmlspecialchars($formattedDate, ENT_QUOTES, 'UTF-8');
                                    ?>
                                </p>
                            </div>

                            <div class="action-user">
                                <i class="bi bi-pencil"></i>
                                <form action="/dashboard/user/edit" method="post" class="form-edit-user" enctype="multipart/form-data">
                                    <input type="hidden" value="<?php echo htmlspecialchars($user['id']); ?>" name="id">
                                    <div class="modal-edit-campaign" style="display: none;">
                                        <div class="container-modal-edit-campaign">
                                            <h4>Editar usuário</h4>

                                            <label>Nome</label>
                                            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">

                                            <div>
                                                <span>
                                                    <label>E-mail</label>
                                                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                                                </span>

                                                <span>
                                                    <label>CPF</label>
                                                    <input type="text" name="cpf" value="<?php echo htmlspecialchars($user['cpf']); ?>" id="cpf2" >
                                                </span>
                                            </div>

                                            <div>
                                                <span>
                                                    <label>Telefone</label>
                                                    <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" id="phone2" >
                                                </span>

                                                <span>
                                                    <label>Data de nascimento</label>
                                                    <input type="text" name="age" value="<?php echo htmlspecialchars($user['age']); ?>" id="age2" >
                                                </span>
                                            </div>

                                            <label>Endereço</label>
                                            <textarea type="text" name="address">
                                                <?php echo htmlspecialchars($user['address']); ?>
                                            </textarea>

                                            <label>Senha</label>
                                            <input type="hidden" name="password_old" value="<?php echo htmlspecialchars($user['password']); ?>">
                                            <input type="password" id="password" name="password">
                                            <i class="bi bi-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
                                            
                                            <input type="hidden" value="<?php echo htmlspecialchars($user['image_user']); ?>" name="img-user-old">
                                            <div class="section-user-image">
                                                <div style="background-image: url('../../public/images/<?php echo htmlspecialchars($user['image_user']); ?>');" class="img-user"></div>

                                                <div style="padding-left: 10px;">
                                                    <label>Foto de usuário: <span style="font-size: .85em; font-weight: 300; color: #0000009c;">(Opcional)</span></label>
                                                    <label for="upload-image-user-<?php echo $user['id']; ?>" class="label-img-user"><i class="bi bi-upload"></i> Escolher arquivo</label>
                                                    <input type="file" accept="image/*" name="image_user" class="upload-image-user" id="upload-image-user-<?php echo $user['id']; ?>">

                                                    <div class="name-file" style="font-size: .8em; font-weight: 300;"></div>
                                                </div>
                                            </div>
                                            <input type="hidden" value="<?php echo htmlspecialchars($user['created_at']); ?>" name="created_at">
                                            <input type="hidden" name="is_admin" value="<?php echo htmlspecialchars($user['isAdmin']); ?>">


                                            <button class="btn-save-user">Salvar</button>
                                        </div>
                                    </div>
                                </form>

                                <?php if (!$user['isAdmin']): ?>
                                <form action="/dashboard/delete-user" method="post" class="form-delete-communication">
                                    <input type="hidden" value="<?php echo htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8'); ?>" name="id">
                                    <button type="button"><i class="bi bi-trash3"></i></button>
                                    <div class="modal-delete-campaign" style="display: none;">
                                        <div class="container-modal-delete-campaign">
                                            <h4>Confirme</h4>
                                            <p>Deseja realmente apagar esse usuário?</p>
                                            <span>
                                                <button type="button" class="delete-campaign-no">Não</button>
                                                <button type="button" class="delete-campaign-yes">Sim</button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <p style="font-size: .8em; font-weight: 300; margin-top: 10px;">Nenhum usuário encontrado.</p>
                    <?php endif; ?>
                </div>

                <div class="pagination">
                    <?php if ($totalPages > 1): ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>" <?php echo ($i == $currentPage) ? 'class="active"' : ''; ?>>
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <script src="../../public/helpers/maskPhone.js"></script>
    <script src="../../public/helpers/maskCPF.js"></script>
    <script src="../../public/js/dashboard/users.js"></script>

</body>
