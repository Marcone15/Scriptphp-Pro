<?php include __DIR__ . '/../partials/header.php'; ?>
<h5 class="title-head" style="display: none;">Configurações</h5>


<body style="max-width: 1300px; margin: auto; background-color: #f5f5f5;">
<?php include __DIR__ . '/../partials/dashboard/sidebar.php'; ?>

    <section class="dashboard-container" style="padding-left: 65px;">
        <div class="dashboard-settings">
            <h1>Configurações</h1>
            <div class="setting-container">
                <div class="nav-bar-settings">
                    <div>
                        <button class="btn-setting"><i class="bi bi-sliders"></i>Definições</button>
                        <button class="btn-customize"><i class="bi bi-brush"></i>Customização</button>
                        <button class="btn-social-media"><i class="bi bi-megaphone"></i>Redes sociais</button>
                        <button class="btn-track"><i class="bi bi-geo-alt"></i>Rastreamento</button>
                        <button class="btn-gateway"><i class="bi bi-wallet2"></i>Gateways</button>
                    </div>
                </div>
                <div class="settings">
                    <form action="/dashboard/update-settings" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($settings['id']); ?>">
                        <div class="settings-content" style="display: block;">
                            <label>Título do site</label>
                            <input type="text" name="name_website" value="<?php echo htmlspecialchars($settings['name_website']); ?>">

                            <div class="form-group">
                                <label>Termos de uso do site</label>
                                <span style="display: flex; gap: 5px; margin-top: -5px;">
                                    <button type="button" id="boldButton"><i class="bi bi-type-bold"></i></button>
                                    <input type="color" id="colorPicker">
                                </span>
                                <div contenteditable="true" id="editor" class="text-editor">
                                    <?php echo htmlspecialchars_decode($settings['term_use']); ?>
                                </div>
                                <textarea name="term_use" id="term_use" style="display: none;">
                                    <?php echo htmlspecialchars($settings['term_use']); ?>
                                </textarea>
                            </div>


                            <div class="form-group">
                                <label for="field_cpf">Habilitar campo CPF:</label>
                                <label class="switch">
                                    <input type="checkbox" id="field_cpf" name="field_cpf" <?php echo $settings['field_cpf'] ? 'checked' : ''; ?>>
                                    <span class="slider round">
                                        <span class="text-on">Sim</span>
                                        <span class="text-off">Não</span>
                                    </span>
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="field_email">Habilitar campo e-mail:</label>
                                <label class="switch">
                                    <input type="checkbox" id="field_email" name="field_email" <?php echo $settings['field_email'] ? 'checked' : ''; ?>>
                                    <span class="slider round">
                                        <span class="text-on">Sim</span>
                                        <span class="text-off">Não</span>
                                    </span>
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="field_age">Habilitar campo idade:</label>
                                <label class="switch">
                                    <input type="checkbox" id="field_age" name="field_age" <?php echo $settings['field_age'] ? 'checked' : ''; ?>>
                                    <span class="slider round">
                                        <span class="text-on">Sim</span>
                                        <span class="text-off">Não</span>
                                    </span>
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="field_address">Habilitar campo endereço:</label>
                                <label class="switch">
                                    <input type="checkbox" id="field_address" name="field_address" <?php echo $settings['field_address'] ? 'checked' : ''; ?>>
                                    <span class="slider round">
                                        <span class="text-on">Sim</span>
                                        <span class="text-off">Não</span>
                                    </span>
                                </label>
                            </div>

                        </div>

                        <div class="cutomize-content" style="display: none;">
                            <span>
                                <label>Cor do Site</label>
                                <input type="color"  value="<?php echo htmlspecialchars($settings['color_website']); ?>" name="color_website">
                            </span>

                            <span class="content-image-logo">
                                <input type="hidden" name="image_logo_old" value="<?php echo htmlspecialchars($settings['image_logo']); ?>">

                                <label>Logotipo do site<span style="font-size: .75em; font-weight: 300; padding-left: 5px;">(Tamanho rec. 500 x 250px)</span></label> 
                                <label for="upload-image-logo" class="label-image-logo"><i class="bi bi-upload"></i> Escolher arquivo</label>
                                <div class="name-file" style="font-size: .8em; font-weight: 300;"></div>
                                <input type="file" accept="image/*" name="image_logo" id="upload-image-logo">

                                <div class="img-logo-view" style="background-image: url('../../public/images/<?php echo htmlspecialchars($settings['image_logo']); ?>');"></div>
                            </span>

                            <span class="content-image-icon">
                                <input type="hidden" name="image_icon_old" value="<?php echo htmlspecialchars($settings['image_icon']); ?>">

                                <label>Ícone do site<span style="font-size: .75em; font-weight: 300; padding-left: 5px;">(Tamanho rec. 95 x 95px)</span></label> 
                                <label for="upload-image-icon" class="label-image-icon"><i class="bi bi-upload"></i> Escolher arquivo</label>
                                <div class="name-file-icon" style="font-size: .8em; font-weight: 300;"></div>
                                <input type="file" accept="image/*" name="image_icon" id="upload-image-icon">

                                <div class="img-icon-view"  style="background-image: url('../../public/images/<?php echo htmlspecialchars($settings['image_icon']); ?>');"></div>
                            </span>
                        </div>
                                           

                        <div class="social-content" style="display: none;">
                            <label>Suporte Whatsapp</label>
                            <input type="text" name="support_wpp" value="<?php echo htmlspecialchars($settings['support_wpp']); ?>">

                            <label>Grupo do Whatsapp</label>
                            <input type="text" name="group_wpp" value="<?php echo htmlspecialchars($settings['group_wpp']); ?>">

                            <label>Link do Instagram</label>
                            <input type="text" name="instagram" value="<?php echo htmlspecialchars($settings['instagram']); ?>">

                            <label>Link do Telegram</label>
                            <input type="text" name="telegram" value="<?php echo htmlspecialchars($settings['telegram']); ?>">

                            <label>Link do Tik Tok</label>
                            <input type="text" name="tiktok" value="<?php echo htmlspecialchars($settings['tiktok']); ?>">
                        </div>

                        <div class="track-content" style="display: none;">
                            <label>Pixel Facebook</label>
                            <input type="text" name="id_pixel_facebook" value="<?php echo htmlspecialchars($settings['id_pixel_facebook']); ?>">

                            <label>Tag do Google Ads</label>
                            <input type="text" name="tag_google" value="<?php echo htmlspecialchars($settings['tag_google']); ?>">
                        </div>

                        <div class="gateway-content" style="display: none;">
                        <div class="form-group">
                                <label for="efi_bank">Habilitar Efí Bank:</label>
                                <label class="switch">
                                    <input type="checkbox" id="efi_bank" name="efi_bank" <?php echo $settings['efi_bank'] ? 'checked' : ''; ?>>
                                    <span class="slider round">
                                        <span class="text-on">Sim</span>
                                        <span class="text-off">Não</span>
                                    </span>
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="paggue">Habilitar Mercado Pago:</label>
                                <label class="switch">
                                    <input type="checkbox" id="paggue" name="paggue" <?php echo $settings['paggue'] ? 'checked' : ''; ?>>
                                    <span class="slider round">
                                        <span class="text-on">Sim</span>
                                        <span class="text-off">Não</span>
                                    </span>
                                </label>
                            </div>

                        </div>

                        <button class="btn-save-settings">Salvar</button>
                    </form>
                </div>
                
            </div>
        </div>
    </section>
    <script src="../../public/js/dashboard/settings.js"></script>
</body>

