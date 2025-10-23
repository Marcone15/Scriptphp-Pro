document.addEventListener('DOMContentLoaded', function() {
    const btnAtivos = document.querySelector('.ativos');
    const btnConcluidos = document.querySelector('.concluídos');
    const divsCampaigns = document.querySelectorAll('.grid-campaign-actives');

    function updateDisplay(activeDivIndex, activeButton) {
        divsCampaigns.forEach((div, index) => {
            if (index === activeDivIndex) {
                div.style.display = 'block';
            } else {
                div.style.display = 'none';
            }
        });

        [btnAtivos, btnConcluidos].forEach(button => {
            if (button === activeButton) {
                button.style.color = '#fff';
                button.style.backgroundColor = '#25CFF2';
            } else {
                button.style.color = '';
                button.style.backgroundColor = '';
            }
        });
    }

    updateDisplay(0, btnAtivos);

    btnAtivos.addEventListener('click', function() {
        updateDisplay(0, btnAtivos);
    });

    btnConcluidos.addEventListener('click', function() {
        updateDisplay(1, btnConcluidos);
    });
});
