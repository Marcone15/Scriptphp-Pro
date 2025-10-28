const cepInput = document.getElementById('cep');

if (cepInput) {
    cepInput.addEventListener('blur', function() {
        const cep = this.value.replace(/\D/g, '');
        if (cep.length === 8) {
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (!data.erro) {
                        document.getElementById('rua').value = data.logradouro;
                        document.getElementById('bairro').value = data.bairro;
                        document.getElementById('cidade').value = data.localidade;
                        document.getElementById('estado').value = data.uf;
                    } else {
                        alert('CEP não encontrado.');
                    }
                })
                .catch(error => console.error('Erro ao buscar o CEP:', error));
        }
    });
}


document.getElementById('upload-image-user').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        document.querySelector('.name-file').textContent = file.name;

        const reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('.img-user').style.backgroundImage = `url(${e.target.result})`;
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordField = document.getElementById('password');
    const passwordIcon = document.getElementById('togglePassword');
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);
    passwordIcon.classList.toggle('bi-eye');
    passwordIcon.classList.toggle('bi-eye-slash');
});


