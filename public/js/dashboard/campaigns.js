document.addEventListener('DOMContentLoaded', function() {
    const showMoreButton = document.getElementById('show-more');
    const campaignsList = document.querySelectorAll('.campaigns-list .campaigns-grid');
    let visibleCount = 10;

    function showMoreCampaigns() {
        for (let i = visibleCount; i < visibleCount + 10 && i < campaignsList.length; i++) {
            campaignsList[i].style.display = 'flex';
        }
        visibleCount += 10;
        if (visibleCount >= campaignsList.length) {
            showMoreButton.style.display = 'none';
        }
    }

    for (let i = 10; i < campaignsList.length; i++) {
        campaignsList[i].style.display = 'none';
    }

    showMoreButton.addEventListener('click', showMoreCampaigns);

    document.querySelectorAll('.bi-trash3').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('form').querySelector('.modal-delete-campaign').style.display = 'flex';
        });
    });

    document.querySelectorAll('.delete-campaign-no').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.modal-delete-campaign').style.display = 'none';
        });
    });

    document.querySelectorAll('.delete-campaign-yes').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('form').submit();
        });
    });

    document.querySelectorAll('.bi-trophy').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.action-campaign').querySelector('.modal-define-winner').style.display = 'flex';
        });
    });

    document.querySelectorAll('.modal-define-winner').forEach(modal => {
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });

    document.querySelectorAll('.form-search-winner').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const campaignId = this.closest('.campaigns-grid').querySelector('input[name="id"]').value;
            const titleNumber = this.querySelector('input[name="title-number"]').value;
    
            fetch(`/dashboard/search-winner?campaign_id=${campaignId}&title_number=${titleNumber}`)
                .then(response => response.text()) 
                .then(text => {
                    const lines = text.trim().split('\n');
                    if (lines[0] === 'success') {
                        const data = {};
                        lines.slice(1).forEach(line => {
                            const [key, value] = line.split(':').map(item => item.trim());
                            if (key && value) {
                                data[key] = value;
                            }
                        });
    
                        const formattedPhone = `${data.phone.substr(0, 10)}****`;
    
                        const formContainer = this.closest('.container-modal-define-winner');
                        const h4 = formContainer.querySelector('h4');
                        h4.textContent = 'Ganhador definido';
    
                        const label = this.querySelector('label');
                        const span = this.querySelector('span');
                        label.style.display = 'none';
                        span.style.display = 'none';
    
                        let winnerDetails = `
                            <div class="img-campaign">
                                <div style="background-image: url('../../public/images/${data.image_raffle}'); width: 20%; height: 60px;"></div>
                                <h4>${data.campaign_name}</h4>
                            </div>
                            <div class="info-winner-define">
                                <p><strong>Ganhador(a): </strong>${data.buyer}</p>
                                <p><strong>Telefone: </strong>${formattedPhone}</p>`;
                        
                        if (data.cpf) {
                            const formattedCPF = `${data.cpf.substr(0, 3)}.***.***-**`;
                            winnerDetails += `<p><strong>CPF: </strong>${formattedCPF}</p>`;
                        }
    
                        winnerDetails += `
                                <p><strong>Número da sorte: </strong><span>${data.number}</span></p>
                                <p><strong>Data da compra: </strong>${data.date}</p>
                                <p style="border-bottom: none;"><strong>Pedido: </strong>#${data.order_code}</p>
                                <a href="https://wa.me/55${data.phone.replace(/[^0-9]/g, '')}" target="_blank"><button><i class="bi bi-whatsapp"></i> Entrar em contato</button></a>
                            </div>
                        `;
                        formContainer.insertAdjacentHTML('beforeend', winnerDetails);
                    } else {
                        alert('Número não encontrado.');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Ocorreu um erro ao buscar o ganhador.');
                });
        });
    });
    
    
      
    
});


document.addEventListener("DOMContentLoaded", function() {
    var campaignsList = document.querySelectorAll(".campaigns-grid");

    if (campaignsList.length === 0) {
        document.getElementById("show-more").style.display = "none";
    }
});


