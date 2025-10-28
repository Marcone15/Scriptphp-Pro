document.addEventListener('DOMContentLoaded', function() {
    var rankingCheckbox = document.getElementById('ranking');
    var rankingDiaryCheckbox = document.getElementById('ranking_diary');
    var rankingPhraseInput = document.querySelector('input[name="ranking_phrase"]');
    var rankingDiaryPhraseInput = document.querySelector('input[name="ranking_diary_phrase"]');

    function updateInputDisplay() {
        rankingPhraseInput.style.display = rankingCheckbox.checked ? 'block' : 'none';
        rankingDiaryPhraseInput.style.display = rankingDiaryCheckbox.checked ? 'block' : 'none';
    }

    updateInputDisplay();

    rankingCheckbox.addEventListener('change', updateInputDisplay);
    rankingDiaryCheckbox.addEventListener('change', updateInputDisplay);

    // Load existing gallery images
    const infoSingle = document.querySelector('.info-single');
    if (infoSingle) {
        const imageRaffleGalery = infoSingle.getAttribute('data-image-raffle-galery');
        if (imageRaffleGalery) {
            const images = imageRaffleGalery.split(', ').filter(img => img.trim() !== '');
            images.forEach((image, index) => {
                if (index < 6) {
                    const fileImageGalery = document.querySelector(`.file-image-galery-${index + 1}`);
                    if (fileImageGalery) {
                        fileImageGalery.style.backgroundImage = `url('../../public/images/${image}')`;
                        fileImageGalery.style.display = 'inline-block';
                    }
                }
            });
        }
    }
});

for (let i = 1; i <= 6; i++) {
    document.getElementById(`image_raffle_galery_${i}`).addEventListener('change', function(event) {
        const file = event.target.files[0];
        const fileNameGalery = document.querySelector(`.file-name-galery-${i}`);
        const fileImageGalery = document.querySelector(`.file-image-galery-${i}`);

        if (file) {
            fileNameGalery.textContent = file.name;

            const reader = new FileReader();
            reader.onload = function(e) {
                fileImageGalery.style.backgroundImage = `url(${e.target.result})`;
                fileImageGalery.style.width = '120px';
                fileImageGalery.style.height = '100px';
                fileImageGalery.style.backgroundSize = 'cover';
                fileImageGalery.style.margin = '5px';
                fileImageGalery.style.display = 'inline-block';
            };
            reader.readAsDataURL(file);
        }
    });
}

