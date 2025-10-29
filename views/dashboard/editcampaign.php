<?php include __DIR__ . '/../partials/header.php'; ?>
<h5 class="title-head" style="display: none;">Editar campanha</h5>


<body style="max-width: 1300px; margin: auto; background-color: #f5f5f5;">
<?php include __DIR__ . '/../partials/dashboard/sidebar.php'; ?>

    <section class="dashboard-container" style="padding-left: 65px;">
        <div class="dashboard-new-campaign">
            <h1>Editar campanha</h1>
            <div class="new-campaign-container">
                <div class="nav-bar-new-campaign">
                    <div>
                        <button class="btn-setting"><i class="bi bi-file-earmark-text"></i>Dados</button>
                        <button class="btn-customize"><i class="bi bi-images"></i>Imagens</button>
                        <button class="btn-customize-2"><i class="bi bi-sliders"></i>Preferências</button>
                        <button class="btn-social-media"><i class="bi bi-percent"></i>Promoções</button>
                        <button class="btn-track"><i class="bi bi-trophy"></i>Títulos premiados</button>
                    </div>
                </div>
                <div class="new-campaign">
                    <form action="/dashboard/campaign/edit/<?php echo htmlspecialchars($campaign['id']); ?>" method="post" enctype="multipart/form-data" class="new-campaign-form">
                       <div class="data-campaign" >

                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($campaign['id']); ?>">

                            <input type="hidden" name="slug" value="<?php echo htmlspecialchars($campaign['slug']); ?>">

                            <input type="hidden" name="created_at" value="<?php echo htmlspecialchars($campaign['created_at']); ?>">

                            <input type="hidden" name="type_raffle" value="<?php echo htmlspecialchars($campaign['type_raffle']); ?>">


                            <label>Título</label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($campaign['name']); ?>" required>

                            <label>Subtítulo</label>
                            <input type="text" name="subname" value="<?php echo htmlspecialchars($campaign['subname']); ?>" required>
                            
                            <div class="form-group">
                                <label>Descrição</label>
                                <span style="display: flex; gap: 5px; margin-top: -5px;">
                                    <button type="button" id="boldButton"><i class="bi bi-type-bold"></i></button>
                                    <input type="color" id="colorPicker">
                                </span>
                                <div contenteditable="true" id="editor" class="text-editor">
                                    <?php echo htmlspecialchars_decode($campaign['description']); ?>
                                </div>
                                <textarea name="description" style="display: none;">
                                    <?php echo htmlspecialchars_decode($campaign['description']); ?>
                                </textarea>
                            </div>

                            <label>Data do sorteio</label>
                            <input type="text" value="<?php echo htmlspecialchars($campaign['draw_date']); ?>" name="draw_date">

                            <label>Preço</label>
                            <input type="text" name="price" required value="<?php echo htmlspecialchars($campaign['price']); ?>">
                        </div>

                        <input type="hidden" name="image_raffle_old" value="<?php echo htmlspecialchars($campaign['image_raffle']); ?>">
                        <input type="hidden" name="image_raffle_galery_old" value="<?php echo htmlspecialchars($campaign['image_raffle_galery']); ?>">

                        <div class="images-campaign" style="display: none;">                            
                            <div class="image-raffle">
                                <label>Imagem principal<span>(Tamanho rec. 720x600px)</span></label>
                                <label for="image_raffle" class="label-image-raffle"><i class="bi bi-upload"></i> Escolher arquivo</label>
                                <div class="file-name" style="font-size: .8em; font-weight: 300;"></div>

                                <input type="file" accept="image/*" name="image_raffle" id="image_raffle" style="display: none;">

                                <div class="file-image"></div>
                            </div>

                            <div class="image-raffle-galery" >
                                <label>Galeria de imagens<span>(Tamanho rec. 720x600px)</span></label>
                                <label for="image_raffle_galery" class="label-image-raffle-galery"><i class="bi bi-upload"></i> Escolher arquivos</label>
                                <div class="file-name-galery" style="font-size: .8em; font-weight: 300;"></div>

                                <input type="file" accept="image/*" name="image_raffle_galery[]" id="image_raffle_galery" style="display: none;" multiple>
                                
                                <div class="file-image-galery"></div>
                            </div>
                        </div>

                        <div class="preference-campaign" style="display: none;">
                            <input type="hidden" name="qtd_numbers" id="qtd_numbers" value="<?php echo htmlspecialchars($campaign['qtd_numbers']); ?>" required>

                            <label>Quantidade mínima p/ compra</label>
                            <input type="number" name="qtd_min" value="<?php echo htmlspecialchars($campaign['qtd_min']); ?>" required>

                            <label>Quantidade máxima p/ compra</label>
                            <input type="number" name="qtd_max" value="<?php echo htmlspecialchars($campaign['qtd_max']); ?>" required>

                            <label class="bigger_smaller_toggle">Opções de compra</label>
                            <input type="text" name="qtd_select" required id="option_buy" value="<?php echo htmlspecialchars($campaign['qtd_select']); ?>">
                            <div id="option-buy-error" style="color: #ad0000; font-size: 0.8em;"></div>

                            <label>Tempo de expiração do PIX</label>
                            <input type="number" name="expiration_pix" value="<?php echo htmlspecialchars($campaign['expiration_pix']); ?>" required>

                            <label>Status da campanha</label>
                            <select name="status">
                                <option value="Adquira já!" <?php echo ($campaign['status'] == 'Adquira já!') ? 'selected' : ''; ?>>Adquira já!</option>
                                <option value="Corre que está acabando!" <?php echo ($campaign['status'] == 'Corre que está acabando!') ? 'selected' : ''; ?>>Corre que está acabando!</option>
                                <option value="Concluído" <?php echo ($campaign['status'] == 'Concluído') ? 'selected' : ''; ?>>Concluído</option>
                            </select>



                            <label for="progress_bar">Ativar barra de progresso</label>
                            <label class="switch">
                                <input type="checkbox" id="progress_bar" name="progress_bar" <?php echo ($campaign['progress_bar'] == 1) ? 'checked' : ''; ?>>
                                <span class="slider round">
                                    <span class="text-on">Sim</span>
                                    <span class="text-off">Não</span>
                                </span>
                            </label>

                            <label for="favorite">Favoritar campanha</label>
                            <label class="switch">
                                <input type="checkbox" id="favorite" name="favorite" <?php echo ($campaign['favorite'] == 1) ? 'checked' : ''; ?>>
                                <span class="slider round">
                                    <span class="text-on">Sim</span>
                                    <span class="text-off">Não</span>
                                </span>
                            </label>

                            <div class="ranking-section">
                                <label for="ranking">Ativar ranking geral</label>
                                <label class="switch">
                                    <input type="checkbox" id="ranking" name="ranking" <?php echo ($campaign['ranking'] == 1) ? 'checked' : ''; ?>>
                                    <span class="slider round">
                                        <span class="text-on">Sim</span>
                                        <span class="text-off">Não</span>
                                    </span>
                                </label>

                                <input type="text" name="ranking_phrase" style="display: <?php echo ($campaign['ranking'] == 1) ? 'block' : 'none'; ?>;" placeholder="Frase para o ranking" value="<?php echo htmlspecialchars($campaign['ranking_phrase']); ?>">
                            </div>

                            <div class="ranking-diary-section">
                                <label for="ranking_diary">Ativar ranking diário</label>
                                <label class="switch">
                                    <input type="checkbox" id="ranking_diary" name="ranking_diary" <?php echo ($campaign['ranking_diary'] == 1) ? 'checked' : ''; ?>>
                                    <span class="slider round">
                                        <span class="text-on">Sim</span>
                                        <span class="text-off">Não</span>
                                    </span>
                                </label>

                                <input type="text" name="ranking_diary_phrase" style="display: <?php echo ($campaign['ranking_diary'] == 1) ? 'block' : 'none'; ?>;" placeholder="Frase para o ranking" value="<?php echo htmlspecialchars($campaign['ranking_diary_phrase']); ?>">
                            </div>


                            <label for="bigger_smaller_title" class="bigger_smaller_title">Ativar maior e menor título<span style="font-size: .8em; font-weight: 300; padding-left: 5px;">(Geral)</span></label>
                            <label class="switch bigger_smaller_toggle">
                                <input type="checkbox" id="bigger_smaller_title" name="bigger_smaller_title" <?php echo ($campaign['bigger_smaller_title'] == 1) ? 'checked' : ''; ?>>
                                <span class="slider round">
                                    <span class="text-on">Sim</span>
                                    <span class="text-off">Não</span>
                                </span>
                            </label>
                            <label for="bigger_smaller_title_diary" class="bigger_smaller_title_diary">Ativar maior e menor título<span style="font-size: .8em; font-weight: 300; padding-left: 5px;">(Diário)</span></label>
                            <label class="switch bigger_smaller_toggle">
                                <input type="checkbox" id="bigger_smaller_title_diary" name="bigger_smaller_title_diary" <?php echo ($campaign['bigger_smaller_title_diary'] == 1) ? 'checked' : ''; ?>>
                                <span class="slider round">
                                    <span class="text-on">Sim</span>
                                    <span class="text-off">Não</span>
                                </span>
                            </label>

                        </div>
                        <?php
                        $qtd_promo_values = array_map('trim', explode(', ', $campaign['qtd_promo'] ?? ''));
                        $price_promo_values = array_map('trim', explode(', ', $campaign['price_promo'] ?? ''));
                        ?>

                        <div class="promotion-campaign" style="display: none;">
                            <label>Quantidade de números</label>
                            <input type="number" name="qtd_promo_1" value="<?php echo !empty($qtd_promo_values[0]) ? htmlspecialchars($qtd_promo_values[0]) : ''; ?>">

                            <label>Valor da promoção</label>
                            <input type="text" name="price_promo_1" value="<?php echo !empty($price_promo_values[0]) ? htmlspecialchars($price_promo_values[0]) : ''; ?>">

                            <label>Quantidade de números</label>
                            <input type="number" name="qtd_promo_2" value="<?php echo !empty($qtd_promo_values[1]) ? htmlspecialchars($qtd_promo_values[1]) : ''; ?>">

                            <label>Valor da promoção</label>
                            <input type="text" name="price_promo_2" value="<?php echo !empty($price_promo_values[1]) ? htmlspecialchars($price_promo_values[1]) : ''; ?>">

                            <label>Quantidade de números</label>
                            <input type="number" name="qtd_promo_3" value="<?php echo !empty($qtd_promo_values[2]) ? htmlspecialchars($qtd_promo_values[2]) : ''; ?>">

                            <label>Valor da promoção</label>
                            <input type="text" name="price_promo_3" value="<?php echo !empty($price_promo_values[2]) ? htmlspecialchars($price_promo_values[2]) : ''; ?>">
                        </div>

                        <div class="draw_titles" style="display: none;">
                            <label>Títulos premiados</label>
                            <p style="font-size: .8em; font-weight: 300; margin-top: -8px; margin-bottom: 7px;">Separe os títulos com virgula e espaço</p>
                            <input type="text" name="draw_titles" placeholder="ex: 222222, 333334, 99999..." id="draw_titles" value="<?php echo htmlspecialchars($campaign['draw_titles']); ?>">

                            <label>Premiações dos títulos premiados</label>
                            <p style="font-size: .8em; font-weight: 300; margin-top: -8px; margin-bottom: 7px;">Separe os prêmios com virgula e espaço</p>
                            <input type="text" name="award_titles" placeholder="ex: R$3.000, Moto 0Km..." id="award_titles" value="<?php echo htmlspecialchars($campaign['award_titles']); ?>">
                        </div>

                        <button class="btn-new-campaign">Salvar</button>
                        <div class="msg-required"></div>
                    </form>
                </div>
                
            </div>
        </div>
    </section>
    <script src="../../public/js/dashboard/newcampaign.js"></script>
    <script src="../../public/js/dashboard/editcampaign.js"></script>
    
</body>

