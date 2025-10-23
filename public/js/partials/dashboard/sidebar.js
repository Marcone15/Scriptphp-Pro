document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.querySelector('.toggle-menu-sidebar');
    const paragraphs = document.querySelectorAll('.content-sidebar p');

    toggleButton.addEventListener('click', function () {
        paragraphs.forEach(paragraph => {
            if (paragraph.style.display === 'none') {
                paragraph.style.display = 'block';
            } else {
                paragraph.style.display = 'none';
            }
        });
    });
});
