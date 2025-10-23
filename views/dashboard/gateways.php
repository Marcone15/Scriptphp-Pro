<?php include __DIR__ . '/../partials/header.php'; ?>
<h5 class="title-head" style="display: none;">Gateways</h5>


<body style="max-width: 1300px; margin: auto; background-color: #f5f5f5;">
<?php include __DIR__ . '/../partials/dashboard/sidebar.php'; ?>
    <section class="dashboard-container" style="padding-left: 65px;">
        <div class="dashboard-gateways">
            <h1>Gateways de pagamento</h1>
            <div class="content-gateways">

                <form class="efi-data" style="display: block;" method="post" action="/api/update-gateway" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($gateways[0]['id']); ?>">
                    
                    <h4>Efí Bank</h4>
                    <label>Client ID</label>
                    <div class="input-container">
                        <input type="password" name="client_id" value="<?php echo htmlspecialchars($gateways[0]['client_id']); ?>">
                        <i class="bi bi-eye-slash toggle-password eye-gat"></i>
                    </div>

                    <label>Client Secret</label>
                    <div class="input-container">
                        <input type="password" name="client_secret" value="<?php echo htmlspecialchars($gateways[0]['client_secret']); ?>">
                        <i class="bi bi-eye-slash toggle-password eye-gat"></i>
                    </div>

                    <label>Chave PIX</label>
                    <div class="input-container">
                        <input type="password" name="pix_key" value="<?php echo htmlspecialchars($gateways[0]['pix_key']); ?>">
                        <i class="bi bi-eye-slash toggle-password eye-gat" ></i>
                    </div>

                    <label>Certificado P12</label>
                    <input type="hidden" name="pix_cert_old" value="<?php echo htmlspecialchars($gateways[0]['pix_cert']); ?>">

                    <div class="input-container">
                    <label for="pix_cert" class="pix_cert"><i class="bi bi bi bi-upload"></i> Escolher arquivo</label>
                    <input type="file" name="pix_cert" id="pix_cert" style="display: none;">
                    <div class="name-file" style="font-size: .8em; font-weight: 300;"></div>

                    <button type="submit">Salvar</button>
                    </div>
                </form>

                <form class="paggue-data" style="display: block;" method="post" action="/api/update-gateway">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($gateways[1]['id']); ?>">

                    <h4 class="h4-paggue">Mercado Pago</h4>
                    <label>Access Token</label>
                    <div class="input-container">
                        <input type="password" name="client_id" value="<?php echo htmlspecialchars($gateways[1]['client_id']); ?>">
                        <i class="bi bi-eye-slash toggle-password eye-gat"></i>
                    </div>

                    <button type="submit">Salvar</button>

                </form>
            </div>
        </div>
    </section>
    <script src="../../public/js/dashboard/gateways.js"></script>
</body>
