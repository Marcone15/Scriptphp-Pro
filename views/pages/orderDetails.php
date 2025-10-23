<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<h5 class="title-head" style="display: none;">Compra</h5>

<body>
    <section>
        <div class="back-range" style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;"></div>

        <input type="hidden" value="<?php echo htmlspecialchars($order['pix_url']); ?>" id="pix_url">
        <input type="hidden" value="<?php echo htmlspecialchars($order['payment_status']); ?>" id="payment_status">

        <div class="container">

            <?php if ($order['payment_status'] === 'pendente'): ?>
            <div class="status-order-pending ord-status">
                <i class="bi bi-clock-history"></i>
                <h4>Aguardando pagamento</h4>
                <p>Finalize o pagamento</p>
            </div>
            <?php endif; ?>

            <div class="status-order-closed ord-status" style="display: none;">
                <i class="bi bi-x-circle"></i>
                <h4>Compra recusada</h4>
                <p>Sua compra foi recusada.</p>
            </div>

            <?php if ($order['payment_status'] === 'cancelado'): ?>
            <div class="status-order-closed ord-status">
                <i class="bi bi-x-circle"></i>
                <h4>Compra recusada</h4>
                <p>Sua compra foi recusada.</p>
            </div>
            <?php endif; ?>

            <?php if ($order['payment_status'] === 'pago'): ?>
            <div class="status-order-paid ord-status">
                <i class="bi bi-check-circle" ></i>
                <h4>Pagamento concluído</h4>
                <p>Agora é só torcer!</p>
            </div>
            <?php endif; ?>

            <?php if ($order['payment_status'] === 'pendente'): ?>
            <div class="spinner-payment"></div>
            <div class="payment-info">
                <div class="timer-section">
                    <div class="timer">
                        <p>Você tem</p>
                        <strong id="timer">00:00</strong>
                        <p>para pagar</p>
                    </div>
                    <div class="progress-bar">
                        <div class="progress_inner_payment" data-order-hash="<?php echo htmlspecialchars($order['hash_order'] ?? ''); ?>" data-expiration-pix="<?php echo htmlspecialchars($order['campaign_expiration_pix'] ?? ''); ?>">
                        </div>
                    </div>
                </div>

                <?php if ($settings['efi_bank'] == true): ?>
                <div>
                    <?php include __DIR__ . '/../../gateways/gerencianet.php'; ?>
                </div>
                <?php endif; ?>

                <?php if ($settings['paggue'] == true): ?>
                <div>
                <?php require_once __DIR__ . '/../../gateways/mercadopago.php'; ?>
                </div>
                <?php endif; ?>

                <?php if ($settings['efi_bank'] == true): ?>
                <div class="section-qrcode" style="display: block;">
                    <div class="description-payment">
                        <div class="code-payment">
                            <p><button>1</button> Copie o código PIX abaixo.</p>
                            <input type="text" id="pixCode" value="<?php echo isset($copiaECola) ? $copiaECola : ''; ?>">
                            <button id="copyButton">Copiar</button>
                        </div>
                        <p><button>2</button> Abra o app do seu banco e escolha a opção PIX.</p>
                        <p><button>3</button> Selecione a opção PIX cópia e cola, cole a chave copiada e confirme.</p>
                        <p class="warn-description">
                            Este pagamento só pode ser realizado dentro do tempo, após este período, caso o pagamento não for confirmado os números voltam a ficar disponíveis.
                        </p> 
                        <span style="display: flex; justify-content: center; border-bottom: solid 1px #C5C5C5; padding-bottom: 15px;">
                           <a href="/compra/<?php echo htmlspecialchars($order['pix_url']); ?>"><button style="padding: 5px 10px; font-size: .9em;"><i class="bi bi-check-all"></i>Já fiz o pagamento</button></a> 
                        </span>                        
                    </div>

                    <div class="qrcode-payment">
                        <div class="description-qrcode">
                            <h4><i class="bi bi-qr-code"></i> QR Code</h4>
                            <p>Acesse o APP do seu banco e escolha a opção <strong>pagar com QR Code</strong>, escaneie o código ao lado e confirme o pagamento.</p>
                        </div>
                        <img src='<?php echo !empty($imagemQRCode) ? $imagemQRCode : "../../public/images/no-image.png"; ?>' alt='QR Code PIX' />
                    </div>
                </div> 
                <?php endif; ?>

                <?php if ($settings['paggue'] == true): ?>
                    <div class="section-qrcode" style="display: block;">
                        <div class="description-payment">
                            <div class="code-payment">
                                <p><button>1</button> Copie o código PIX abaixo.</p>
                                <input type="text" id="pixCode" value="<?php echo isset($pagamento->point_of_interaction->transaction_data->qr_code) ? $pagamento->point_of_interaction->transaction_data->qr_code : ''; ?>">
                                <button id="copyButton">Copiar</button>
                            </div>
                            <p><button>2</button> Abra o app do seu banco e escolha a opção PIX.</p>
                            <p><button>3</button> Selecione a opção PIX cópia e cola, cole a chave copiada e confirme.</p>
                            <p class="warn-description">
                                Este pagamento só pode ser realizado dentro do tempo, após este período, caso o pagamento não for confirmado os números voltam a ficar disponíveis.
                            </p> 
                            <span style="display: flex; justify-content: center; border-bottom: solid 1px #C5C5C5; padding-bottom: 15px;">
                            <a href="/compra/<?php echo htmlspecialchars($order['pix_url']); ?>"><button style="padding: 5px 10px; font-size: .9em;"><i class="bi bi-check-all"></i>Já fiz o pagamento</button></a> 
                            </span>                        
                        </div>

                        <div class="qrcode-payment">
                            <div class="description-qrcode">
                                <h4><i class="bi bi-qr-code"></i> QR Code</h4>
                                <p>Acesse o APP do seu banco e escolha a opção <strong>pagar com QR Code</strong>, escaneie o código ao lado e confirme o pagamento.</p>
                            </div>
                            <?php
                            $imagemQRCode = $pagamento->point_of_interaction->transaction_data->qr_code_base64 ? "data:image/png;base64," . $pagamento->point_of_interaction->transaction_data->qr_code_base64 : "../../public/images/no-image.png";
                            ?>
                            <img style="height: 180px; padding: 10px;" id="qr-code" src="<?php echo $imagemQRCode; ?>" alt="QR Code PIX" />
                        </div>
                    </div>

                <?php endif; ?>

            </div>
            

            <div class="reload-page-message">
                <i class="bi bi-info-circle"></i> 
                <p> 
                 Após o pagamento aguarde até 5 minutos para a confirmação.
                </p>
            </div>
            <?php endif; ?>
            <span style="display: none;">
                <p><strong>Preço: </strong><?php echo htmlspecialchars($order['price'] ?? ''); ?></p>
                <p><strong>Nome: </strong><?php echo htmlspecialchars($order['campaign_name'] ?? ''); ?></p>
                <p><strong>Id produto: </strong><?php echo htmlspecialchars($order['id_campaign'] ?? ''); ?></p>

                <p><strong>Id: </strong><?php echo htmlspecialchars($order['pix_url'] ?? ''); ?></p>
            </span>

            <div class="order-info">
                <h4><i class="bi bi-info-circle"> Detalhes da sua compra</i></h4>
                <p><strong>Comprador: </strong><?php echo htmlspecialchars($order['user_name'] ?? ''); ?></p>

                <?php if ($order['user_cpf']): ?>
                    <p><strong>CPF: </strong><?php echo substr(htmlspecialchars($order['user_cpf'] ?? ''), 0,3); ?>.***.***-**</p>
                <?php endif; ?>
                <p><strong>Telefone: </strong><?php echo substr(htmlspecialchars($order['user_phone'] ?? ''), 0, 4); ?>*****-****</p>

                <?php if ($order['user_email']): ?>
                    <p><strong>E-mail: </strong><?php echo substr(htmlspecialchars($order['user_email'] ?? ''), 0,3); ?>******@****.com</p>
                <?php endif; ?>

                <p><strong>Data/Horário: </strong><?php echo date('d/m/y \à\s H:i', strtotime(htmlspecialchars($order['created_at'] ?? ''))); ?> </p>

                <p><strong>Data de expiração: </strong><?php echo date('d/m/y \à\s H:i', strtotime(htmlspecialchars($order['expiration_date'] ?? ''))); ?> </p>

                <p><strong>Quantidade: </strong><?php echo htmlspecialchars($order['quantity'] ?? ''); ?> </p>
                <p><strong>Total: </strong><span>R$ </span><?php echo htmlspecialchars($order['total'] ?? ''); ?> </p>

                <?php if ($order['campaign_type_raffle'] === 'Automática'): ?>
                    <p><strong>Títulos: </strong>Os títulos são liberados após o pagamento</p>
                <?php else: ?>
                    
                <p style="border-bottom: none;"><strong>Títulos: </strong></p>
                    <?php foreach (explode(',', $order['numbers']) as $number): ?>
                        <button><?php echo htmlspecialchars(trim($number)); ?></button>
                    <?php endforeach; ?>
             <?php endif; ?>
            </div>
            <a href="/contato" class="contact-payment">Problemas com sua compra? <strong>clique aqui</strong>.</a>
        </div>
    </section>
    <script src="../../public/js/pages/orderDetails.js"></script>
    <script>
    <?php
        $total = str_replace(',', '.', $order['total']);
        $totalFloat = floatval($total);
        ?>
        
        fbq('track', 'AddToCart', {
            content_name: '<?php echo htmlspecialchars($order['campaign_name']); ?>',
            content_ids: ['<?php echo htmlspecialchars($order['campaign_id']); ?>'],
            content_type: 'product',
            value: <?php echo htmlspecialchars($totalFloat); ?>,
            currency: 'BRL',
            contents: [{
                id: '<?php echo htmlspecialchars($order['campaign_id']); ?>',
                quantity: <?php echo htmlspecialchars($order['quantity']); ?>
            }]
        });
    </script>












<?php include __DIR__ . '/../partials/footer.php'; ?>