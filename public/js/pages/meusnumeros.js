document.addEventListener('DOMContentLoaded', function() {
    const btns = document.querySelectorAll('.btn-show-numbers');

    btns.forEach(btn => {
        btn.addEventListener('click', function() {
            const numbersDiv = this.closest('.grid-results-order').querySelector('.result-number-order');
            if (numbersDiv.style.display === 'none' || numbersDiv.style.display === '') {
                numbersDiv.style.display = 'block';
            } else {
                numbersDiv.style.display = 'none';
            }
        });
    });
});

