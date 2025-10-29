document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordField = document.getElementById('password');
    const passwordIcon = document.getElementById('togglePassword');
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);
    passwordIcon.classList.toggle('bi-eye');
    passwordIcon.classList.toggle('bi-eye-slash');
});

document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    const phoneInput = document.getElementById('phone');

    loginForm.addEventListener('submit', function (event) {
        if (!phoneInput.value) {
            event.preventDefault();
            alert('O campo de telefone é obrigatório.');
        }
    });
});




