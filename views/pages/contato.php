<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<h5 class="title-head" style="display: none;">Contato</h5>

<body>
    <section>
        <div class="back-range" style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;"></div>
        <div class="container" style="height: max-content;">
            <div class="faq">
                <div class="title-faq">
                        <h2 style="margin-top: 3px;">🤷 Perguntas frequentes</h2>
                </div>
                <div class="container-faq">
                    <h4 class="faq-1">
                        <i class="bi bi-arrow-right"></i>
                        Acessando suas compras
                    </h4>
                    <p class="response-1">
                    Existem duas formas de você conseguir acessar suas compras, a primeira é logando no site, abrindo o menu do site e clicando em "Entrar" e a segunda forma é visitando a campanha e clicando em "Meus títulos" logo a baixo do nome da campanha.
                    </p>
                </div>

                <div class="container-faq">
                    <h4 class="faq-2">
                        <i class="bi bi-arrow-right"></i>
                        Como é o processo do sorteio?
                    </h4>
                    <p class="response-2">
                    O sorteio será realizado com base na extração da Loteria Federal, conforme Condições de Participação constantes no título.
                    </p>
                </div>

                <div class="container-faq">
                    <h4 class="faq-3">
                        <i class="bi bi-arrow-right"></i>
                        Onde o prêmio será entregue?
                    </h4>
                    <p class="response-3">
                    Não há necessidade de se preocupar com os trâmites relacionados à entrega do prêmio, pois nós cuidaremos de tudo.
                    </p>
                </div>
            </div>
                 
            <span class="title">
                <h1><i class="bi bi-whatsapp"></i> Contato</h1>
                <p>Tire suas dúvidas.</p>
            </span>    
            <div class="form-contact">
                <form action="">
                    <label>Nome</label>
                    <input type="text" name="name" required>

                    <label>Telefone</label>
                    <input type="text" name="phone" id="phone" required>

                    <label>Campanha</label>
                    <input type="text" name="campaign" required>

                    <label>Assunto</label>
                    <input type="text" name="subject" required>

                    <label>Mensagem</label>
                    <textarea name="message" minlength="20" required></textarea>
                    <p>mínimo de 20 caracteres</p>

                    <button>Enviar <i class="bi bi-arrow-right"></i></button>
                </form>
            </div>       
        </div>
    </section>
    <script src="../../public/js/pages/home.js"></script>
    <script src="../../public/helpers/maskPhone.js"></script>
    <script>
        document.querySelector('.form-contact form').addEventListener('submit', function(event) {
            event.preventDefault(); 
    
            var name = document.querySelector('input[name="name"]').value;
            var phone = document.querySelector('input[name="phone"]').value;
            var campaign = document.querySelector('input[name="campaign"]').value;
            var subject = document.querySelector('input[name="subject"]').value;
            var message = document.querySelector('textarea[name="message"]').value;
    
            var whatsappMessage = `Nome: ${name}\nTelefone: ${phone}\nCampanha: ${campaign}\nAssunto: ${subject}\nMensagem: ${message}`;
    
            var encodedMessage = encodeURIComponent(whatsappMessage);
    
            var supportWppNumber = "<?php echo $settings['support_wpp']; ?>";
    
            var whatsappUrl = `https://wa.me/55${supportWppNumber}?text=${encodedMessage}`;
    
            window.location.href = whatsappUrl;
        });
    </script>

<?php include __DIR__ . '/../partials/footer.php'; ?>


