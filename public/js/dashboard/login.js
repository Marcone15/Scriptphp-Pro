document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const submitButton = form.querySelector('.btn-register');
    const buttonText = submitButton.querySelector('.btn-text');
    const spinner = submitButton.querySelector('.spinner-gif');

    form.addEventListener('submit', function (event) {
        event.preventDefault(); 

        buttonText.style.display = 'none';
        spinner.style.display = 'block';

        setTimeout(function () {
            form.submit();
        }, 1000);
    });
});
