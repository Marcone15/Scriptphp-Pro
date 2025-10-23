document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.bi-x-circle').forEach((icon, index) => {
        icon.addEventListener('click', (event) => {
            event.preventDefault();
            document.querySelectorAll('.modal-delete-order')[index].style.display = 'flex';
        });
    });

    document.querySelectorAll('.cancel-order-no').forEach((button, index) => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.modal-delete-order')[index].style.display = 'none';
        });
    });

    document.querySelectorAll('.cancel-order-yes').forEach((button, index) => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.modal-delete-order')[index].parentElement.submit();
        });
    });

    document.querySelectorAll('.bi-check-circle').forEach((icon, index) => {
        icon.addEventListener('click', () => {
            document.querySelectorAll('.action-order-detail form')[index].submit();
        });
    });
});





