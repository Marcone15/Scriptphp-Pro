<?php include __DIR__ . '/../partials/header.php'; ?>
<h5 class="title-head" style="display: none;">Nova campanha</h5>


<body style="max-width: 1300px; margin: auto; background-color: #f5f5f5;">
<?php include __DIR__ . '/../partials/dashboard/sidebar.php'; ?>

    <section class="dashboard-container" style="padding-left: 65px;">
        <div class="dashboard-new-campaign">
            <h1>Nova campanha</h1>
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
                    <form action="/dashboard/campaign/create" method="post" enctype="multipart/form-data" class="new-campaign-form">
                       <div class="data-campaign" >
                            <label>Tipo de campanha</label>
                            <select name="type_raffle" required>
                                <option value="Automática">Automática</option>
                                <option value="Normal">Normal</option>
                                <option value="Fazendinha">Fazendinha</option>
                            </select> 

                            <label>Título</label>
                            <input type="text" name="name" required>

                            <label>Subtítulo</label>
                            <input type="text" name="subname" required>
                            
                            <div class="form-group">
                                <label>Descrição</label>
                                <span style="display: flex; gap: 5px; margin-top: -5px;">
                                    <button type="button" id="boldButton"><i class="bi bi-type-bold"></i></button>
                                    <input type="color" id="colorPicker">
                                </span>
                                <div contenteditable="true" id="editor" class="text-editor">
                                    
                                </div>
                                <textarea name="description" style="display: none;">

                                </textarea>
                            </div>

                            <label>Data do sorteio</label>
                            <input type="text" placeholder="ex: 19/03/24 às 19:00" name="draw_date">

                            <label>Preço</label>
                            <input type="text" name="price" required placeholder="ex: 0,01">
                        </div>

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
                                <div class="galery-inputs">
                                    <div class="galery-item">
                                        <label for="image_raffle_galery_1" class="label-image-raffle-galery"><i class="bi bi-upload"></i> Escolher arquivo 1</label>
                                        <div class="file-name-galery-1" style="font-size: .8em; font-weight: 300;"></div>
                                        <input type="file" accept="image/*" name="image_raffle_galery[]" id="image_raffle_galery_1" style="display: none;">
                                        <div class="file-image-galery-1"></div>
                                    </div>
                                    <div class="galery-item">
                                        <label for="image_raffle_galery_2" class="label-image-raffle-galery"><i class="bi bi-upload"></i> Escolher arquivo 2</label>
                                        <div class="file-name-galery-2" style="font-size: .8em; font-weight: 300;"></div>
                                        <input type="file" accept="image/*" name="image_raffle_galery[]" id="image_raffle_galery_2" style="display: none;">
                                        <div class="file-image-galery-2"></div>
                                    </div>
                                    <div class="galery-item">
                                        <label for="image_raffle_galery_3" class="label-image-raffle-galery"><i class="bi bi-upload"></i> Escolher arquivo 3</label>
                                        <div class="file-name-galery-3" style="font-size: .8em; font-weight: 300;"></div>
                                        <input type="file" accept="image/*" name="image_raffle_galery[]" id="image_raffle_galery_3" style="display: none;">
                                        <div class="file-image-galery-3"></div>
                                    </div>
                                    <div class="galery-item">
                                        <label for="image_raffle_galery_4" class="label-image-raffle-galery"><i class="bi bi-upload"></i> Escolher arquivo 4</label>
                                        <div class="file-name-galery-4" style="font-size: .8em; font-weight: 300;"></div>
                                        <input type="file" accept="image/*" name="image_raffle_galery[]" id="image_raffle_galery_4" style="display: none;">
                                        <div class="file-image-galery-4"></div>
                                    </div>
                                    <div class="galery-item">
                                        <label for="image_raffle_galery_5" class="label-image-raffle-galery"><i class="bi bi-upload"></i> Escolher arquivo 5</label>
                                        <div class="file-name-galery-5" style="font-size: .8em; font-weight: 300;"></div>
                                        <input type="file" accept="image/*" name="image_raffle_galery[]" id="image_raffle_galery_5" style="display: none;">
                                        <div class="file-image-galery-5"></div>
                                    </div>
                                    <div class="galery-item">
                                        <label for="image_raffle_galery_6" class="label-image-raffle-galery"><i class="bi bi-upload"></i> Escolher arquivo 6</label>
                                        <div class="file-name-galery-6" style="font-size: .8em; font-weight: 300;"></div>
                                        <input type="file" accept="image/*" name="image_raffle_galery[]" id="image_raffle_galery_6" style="display: none;">
                                        <div class="file-image-galery-6"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="preference-campaign" style="display: none;">
                            <label class="label-qtd-numbers">Quantidade de números</label>
                            <input type="number" name="qtd_numbers" id="qtd_numbers" required>

                            <label>Quantidade mínima p/ compra</label>
                            <input type="number" name="qtd_min" required>

                            <label>Quantidade máxima p/ compra</label>
                            <input type="number" name="qtd_max"  class="qtd_max" required>

                            <label class="bigger_smaller_toggle">Opções de compra</label>
                            <input type="text" name="qtd_select" id="option_buy" placeholder="ex: 20, 40, 100, 200, 300, 500">
                            <div id="option-buy-error" style="color: #ad0000; font-size: 0.8em;"></div>

                            <label>Tempo de expiração do PIX</label>
                            <input type="number" name="expiration_pix" required>

                            <label>Status da campanha</label>
                            <select name="status">
                                <option value="Adquira já!">Adquira já!</option>
                                <option value="Corre que está acabando!">Corre que está acabando!</option>
                            </select>


                            <label for="progress_bar">Ativar barra de progresso</label>
                                <label class="switch">
                                    <input type="checkbox" id="progress_bar" name="progress_bar">
                                    <span class="slider round">
                                        <span class="text-on">Sim</span>
                                        <span class="text-off">Não</span>
                                    </span>
                                </label>

                            <label for="favorite">Favoritar campanha</label>
                            <label class="switch">
                                <input type="checkbox" id="favorite" name="favorite">
                                <span class="slider round">
                                    <span class="text-on">Sim</span>
                                    <span class="text-off">Não</span>
                                </span>
                            </label>

                            <div class="ranking-section">
                                <label for="ranking">Ativar ranking geral</label>
                                <label class="switch">
                                    <input type="checkbox" id="ranking" name="ranking">
                                    <span class="slider round">
                                        <span class="text-on">Sim</span>
                                        <span class="text-off">Não</span>
                                    </span>
                                </label>

                                <input type="text" name="ranking_phrase" style="display: none;" placeholder="Frase para o ranking">
                            </div>

                            <div class="ranking-diary-section" >
                                <label for="ranking_diary">Ativar ranking diário</label>
                                <label class="switch">
                                    <input type="checkbox" id="ranking_diary" name="ranking_diary">
                                    <span class="slider round">
                                        <span class="text-on">Sim</span>
                                        <span class="text-off">Não</span>
                                    </span>
                                </label>

                                <input type="text" name="ranking_diary_phrase" style="display: none;" placeholder="Frase para o ranking">
                            </div>

                            <label for="bigger_smaller_title" class="bigger_smaller_title">Ativar maior e menor título<span style="font-size: .8em; font-weight: 300; padding-left: 5px;">(Geral)</span></label>
                                <label class="switch bigger_smaller_toggle">
                                    <input type="checkbox" id="bigger_smaller_title"  name="bigger_smaller_title">
                                    <span class="slider round">
                                        <span class="text-on">Sim</span>
                                        <span class="text-off">Não</span>
                                    </span>
                                </label>

                            <label for="bigger_smaller_title_diary" class="bigger_smaller_title_diary" >Ativar maior e menor título<span style="font-size: .8em; font-weight: 300; padding-left: 5px;">(Diário)</span></label>
                            <label class="switch bigger_smaller_toggle">
                                <input type="checkbox" id="bigger_smaller_title_diary" name="bigger_smaller_title_diary">
                                <span class="slider round">
                                    <span class="text-on">Sim</span>
                                    <span class="text-off">Não</span>
                                </span>
                            </label>
                        </div>

                        <div class="promotion-campaign" style="display: none;">
                            <label>Quantidade de números</label>
                            <input type="number" name="qtd_promo_1">

                            <label>Valor da promoção</label>
                            <input type="text" name="price_promo_1">

                            <label>Quantidade de números</label>
                            <input type="number" name="qtd_promo_2">

                            <label>Valor da promoção</label>
                            <input type="text" name="price_promo_2">

                            <label>Quantidade de números</label>
                            <input type="number" name="qtd_promo_3">

                            <label>Valor da promoção</label>
                            <input type="text" name="price_promo_3">
                        </div>

                        <div class="draw_titles" style="display: none;">
                            <label>Títulos premiados</label>
                            <p style="font-size: .8em; font-weight: 300; margin-top: -8px; margin-bottom: 7px;">Separe os títulos com virgula e espaço</p>
                            <input type="text" name="draw_titles" placeholder="ex: 222222, 333334, 99999..." id="draw_titles">

                            <label>Premiações dos títulos premiados</label>
                            <p style="font-size: .8em; font-weight: 300; margin-top: -8px; margin-bottom: 7px;">Separe os prêmios com virgula e espaço</p>
                            <input type="text" name="award_titles" placeholder="ex: R$3.000, Moto 0Km..." id="award_titles">
                        </div>

                        <button class="btn-new-campaign">Criar</button>
                        <div class="msg-required"></div>
                    </form>
                </div>
                
            </div>
        </div>
    </section>
    <script src="../../public/js/dashboard/newcampaign.js"></script>
</body>

