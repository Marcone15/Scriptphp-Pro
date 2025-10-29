document.addEventListener('DOMContentLoaded', function () {
    const efiData = document.querySelector('.efi-data');
    const paggueData = document.querySelector('.paggue-data');
    const togglePasswordIcons = document.querySelectorAll('.toggle-password');

    togglePasswordIcons.forEach(icon => {
        icon.addEventListener('click', function () {
            const input = this.previousElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
                this.className = 'bi bi-eye';
            } else {
                input.type = 'password';
                this.className = 'bi bi-eye-slash';
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const pixCertInput = document.getElementById('pix_cert');
    const fileNameDiv = document.querySelector('.name-file');

    pixCertInput.addEventListener('change', function () {
        const fileName = this.files[0] ? this.files[0].name : '';
        fileNameDiv.textContent = fileName;
    });
});




