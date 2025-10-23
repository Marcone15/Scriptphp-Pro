document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".phone-user i").forEach(toggleIcon => {
        toggleIcon.addEventListener("click", function() {
            const input = this.previousElementSibling;
            if (input.type === "password") {
                input.type = "text";
                this.classList.remove("bi-eye");
                this.classList.add("bi-eye-slash");
            } else {
                input.type = "password";
                this.classList.remove("bi-eye-slash");
                this.classList.add("bi-eye");
            }
        });
    });

    document.querySelectorAll(".bi-trash3").forEach(deleteButton => {
        deleteButton.addEventListener("click", function(e) {
            e.preventDefault();
            const modal = this.closest("form").querySelector(".modal-delete-campaign");
            modal.style.display = "flex";
        });
    });

    document.querySelectorAll(".delete-campaign-no").forEach(cancelButton => {
        cancelButton.addEventListener("click", function() {
            this.closest(".modal-delete-campaign").style.display = "none";
        });
    });

    document.querySelectorAll(".delete-campaign-yes").forEach(confirmButton => {
        confirmButton.addEventListener("click", function() {
            this.closest("form").submit();
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.bi-pencil').forEach((icon, index) => {
        icon.addEventListener('click', () => {
            document.querySelectorAll('.modal-edit-campaign')[index].style.display = 'flex';
        });

        window.addEventListener('click', (event) => {
            if (event.target.classList.contains('modal-edit-campaign')) {
                document.querySelectorAll('.modal-edit-campaign')[index].style.display = 'none';
            }
        });
    });

    document.querySelectorAll('#togglePassword').forEach((icon, index) => {
        icon.addEventListener('click', () => {
            const passwordInput = document.querySelectorAll('#password')[index];
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    });

    function applyCpfMask(input) {
        input.addEventListener('input', () => {
            input.value = input.value
                .replace(/\D/g, '')
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d{1,2})$/, '$1-$2')
                .replace(/(-\d{2})\d+?$/, '$1');
        });
    }

    function applyPhoneMask(input) {
        input.addEventListener('input', () => {
            input.value = input.value
                .replace(/\D/g, '')
                .replace(/(\d{2})(\d)/, '($1)$2')
                .replace(/(\d{5})(\d)/, '$1-$2')
                .replace(/(-\d{4})\d+?$/, '$1');
        });
    }    

    function applyAgeMask(input) {
        input.addEventListener('input', () => {
            input.value = input.value
                .replace(/\D/g, '')
                .replace(/(\d{2})(\d)/, '$1/$2')
                .replace(/(\d{2})(\d)/, '$1/$2')
                .replace(/(\d{4})\d+?$/, '$1');
        });
    }

    document.querySelectorAll('#cpf2').forEach(applyCpfMask);
    document.querySelectorAll('#phone2').forEach(applyPhoneMask);
    document.querySelectorAll('#age2').forEach(applyAgeMask);

    document.querySelectorAll('.upload-image-user').forEach((input, index) => {
        input.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.querySelectorAll('.img-user')[index].style.backgroundImage = `url(${e.target.result})`;
                };
                reader.readAsDataURL(file);

                document.querySelectorAll('.name-file')[index].innerText = file.name;
            }
        });
    });

});






