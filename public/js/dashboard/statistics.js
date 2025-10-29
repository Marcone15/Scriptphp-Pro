document.addEventListener('DOMContentLoaded', function () {
    const toggleRevenue = document.getElementById('toggle-revenue');
    const revenueInput = document.getElementById('revenue-input');

    revenueInput.type = 'password';
    toggleRevenue.classList.add('bi-eye-slash');
    toggleRevenue.classList.remove('bi-eye');

    toggleRevenue.addEventListener('click', function () {
        if (revenueInput.type === 'password') {
            revenueInput.type = 'text';
            toggleRevenue.classList.add('bi-eye');
            toggleRevenue.classList.remove('bi-eye-slash');
        } else {
            revenueInput.type = 'password';
            toggleRevenue.classList.add('bi-eye-slash');
            toggleRevenue.classList.remove('bi-eye');
        }
    });
});

