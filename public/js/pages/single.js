function hideSubMenu() {
    const subMenu = document.querySelector('.sub-menu-nav');
    subMenu.style.display = 'none';
}
hideSubMenu();


document.addEventListener('DOMContentLoaded', function() {
    const btnDescription = document.querySelector('.btn-Description');
    const descriptionDiv = document.querySelector('.description');
    const arrowIcon = btnDescription.querySelector('i');

    btnDescription.addEventListener('click', function() {
        if (descriptionDiv.style.display === 'none' || descriptionDiv.style.display === '') {
            descriptionDiv.style.display = 'block';
            arrowIcon.classList.remove('bi-arrow-down-square-fill');
            arrowIcon.classList.add('bi-arrow-up-square-fill');
        } else {
            descriptionDiv.style.display = 'none';
            arrowIcon.classList.remove('bi-arrow-up-square-fill');
            arrowIcon.classList.add('bi-arrow-down-square-fill');
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const infoSingle = document.querySelector('.info-single');
    const imgSingle = document.getElementById('imgSingle');
    const prevSlide = document.getElementById('prevSlide');
    const nextSlide = document.getElementById('nextSlide');

    const imageRaffle = infoSingle.getAttribute('data-image-raffle');
    const imageRaffleGalery = infoSingle.getAttribute('data-image-raffle-galery').split(', ');

    let images = [imageRaffle, ...imageRaffleGalery].filter(image => image.trim() !== '');
    let currentIndex = 0;
    let autoSlideInterval;

    function updateSlide() {
        imgSingle.style.backgroundImage = `url('../../public/images/${images[currentIndex]}')`;
    }

    function startAutoSlide() {
        autoSlideInterval = setInterval(function() {
            currentIndex = (currentIndex === images.length - 1) ? 0 : currentIndex + 1;
            updateSlide();
        }, 3000); // Alterna a cada 3 segundos
    }

    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }

    if (images.length > 1) {
        prevSlide.addEventListener('click', function() {
            stopAutoSlide();
            currentIndex = (currentIndex === 0) ? images.length - 1 : currentIndex - 1;
            updateSlide();
            startAutoSlide();
        });

        nextSlide.addEventListener('click', function() {
            stopAutoSlide();
            currentIndex = (currentIndex === images.length - 1) ? 0 : currentIndex + 1;
            updateSlide();
            startAutoSlide();
        });

        startAutoSlide();
    } else {
        prevSlide.style.display = 'none';
        nextSlide.style.display = 'none';
    }

    updateSlide();
});







