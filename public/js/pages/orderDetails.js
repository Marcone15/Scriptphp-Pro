function hideSubMenu() {
    const subMenu = document.querySelector('.sub-menu-nav');
    subMenu.style.display = 'none';
}
hideSubMenu();

document.addEventListener('DOMContentLoaded', function() {
    const expirationPixElem = document.querySelector('.progress_inner_payment');
    const orderHash = expirationPixElem.getAttribute('data-order-hash');
    const pixUrl = document.getElementById('pix_url').value; 

    function fetchExpirationTime(pixUrl) {
        return fetch(`/get-expiration-time?pix_url=${pixUrl}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao buscar o tempo de expiração');
                }
                return response.json();
            })
            .then(data => {
                console.log('Tempo de expiração recuperado:', data.expiration_time);
                return data.expiration_time;
            });
    }

    async function initializeTimer() {
        try {
            const expirationTime = await fetchExpirationTime(pixUrl);
            if (expirationTime) {
                const endTime = new Date(expirationTime).getTime();
                startTimer(endTime, document.querySelector('#timer'));
            } else {
                console.error('Tempo de expiração não encontrado');
            }
        } catch (error) {
            console.error('Erro ao inicializar o timer:', error);
        }
    }

    function updateProgressBar(secondsRemaining, totalSeconds) {
        const progressBar = document.querySelector('.progress_inner_payment');
        const percentage = ((totalSeconds - secondsRemaining) / totalSeconds) * 100;
        progressBar.style.width = `${percentage}%`;
    }


    function startTimer(endTime, display) {
        const totalSeconds = Math.round((endTime - new Date().getTime()) / 1000);
        let timer = totalSeconds, minutes, seconds;

        const interval = setInterval(function () {
            const now = new Date().getTime();
            const remainingTime = endTime - now;
            const paymentInfo = document.querySelector('.payment-info');
            const reloadPageMessage = document.querySelector('.reload-page-message');
            const statusOrderPending = document.querySelector('.status-order-pending');
            const statusOrderClosed = document.querySelector('.status-order-closed');

            if (remainingTime <= 0) {
                clearInterval(interval);
                paymentInfo.style.display = 'none';
                reloadPageMessage.style.display = 'none';
                statusOrderPending.style.display = 'none';
                statusOrderClosed.style.display = 'block';
                return;
            }

            timer = Math.floor(remainingTime / 1000);
            minutes = Math.floor(timer / 60);
            seconds = timer % 60;

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;
            updateProgressBar(timer, totalSeconds);
        }, 1000);
    }

    initializeTimer();
});



document.addEventListener('DOMContentLoaded', function() {
    const copyButton = document.getElementById('copyButton');
    const pixCodeInput = document.getElementById('pixCode');

    copyButton.addEventListener('click', function() {
        pixCodeInput.select();
        pixCodeInput.setSelectionRange(0, 99999); 
        navigator.clipboard.writeText(pixCodeInput.value).then(function() {
            copyButton.textContent = 'Copiado';
            setTimeout(() => {
                copyButton.textContent = 'Copiar';
            }, 2000);
        }).catch(function(error) {
            console.error('Erro ao copiar texto: ', error);
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const paymentStatusInput = document.getElementById('payment_status');
    const pixUrl = document.getElementById('pix_url').value; 

    if (paymentStatusInput) {
        const paymentStatus = paymentStatusInput.value;

        if (paymentStatus === 'pago') {
            window.location.href = `/obrigado/${pixUrl}`;
        }
    }
});







