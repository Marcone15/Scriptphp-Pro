document.addEventListener('DOMContentLoaded', function() {
    function loadCampaigns() {
        fetch('/api/campaigns')
            .then(response => response.json())
            .then(campaigns => {
                const select = document.getElementById('select-campaign-order');
                select.innerHTML = '<option value="">Todas</option>';
                campaigns.forEach(campaign => {
                    const option = document.createElement('option');
                    option.value = campaign.id;
                    option.textContent = campaign.name;
                    select.appendChild(option);
                });
            })
            .catch(error => console.error('Erro ao carregar campanhas:', error));
    }

    document.querySelector('.filter-orders form').addEventListener('submit', function(event) {
        event.preventDefault();
        const campaignId = document.getElementById('select-campaign-order').value;
        const orderHash = document.getElementById('pedido').value;
        const titleNumber = document.getElementById('titulo').value;
        const clientName = document.getElementById('cliente').value;

        const params = new URLSearchParams();
        if (campaignId) params.append('campaign_id', campaignId);
        if (orderHash) params.append('order_hash', orderHash);
        if (titleNumber) params.append('title_number', titleNumber);
        if (clientName) params.append('client_name', clientName);

        window.location.href = `/dashboard/orders?${params.toString()}`;
    });

    document.querySelectorAll('.form-delete-order button[type="button"]').forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.actions-order').querySelector('.modal-delete-order');
            modal.style.display = 'flex';
        });
    });

    document.querySelectorAll('.delete-order-no').forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal-delete-order');
            modal.style.display = 'none';
        });
    });

    document.querySelectorAll('.delete-order-yes').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.closest('form').querySelector('input[name="id"]').value;
            fetch(`/dashboard/delete-order`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: orderId }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(result => {
                if (result.success) {
                    location.reload();
                } else {
                    alert('Erro ao apagar o pedido.');
                }
            })
            .catch(error => console.error('Erro ao apagar o pedido:', error));
        });
    });

    loadCampaigns();
});
