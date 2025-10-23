document.addEventListener("DOMContentLoaded", function() {
    const editor = document.getElementById("editor");
    const termUseTextarea = document.getElementById("term_use");

    document.getElementById("boldButton").addEventListener("click", function() {
        document.execCommand("bold", false, null);
    });

    document.getElementById("colorPicker").addEventListener("input", function() {
        const color = this.value;
        document.execCommand("foreColor", false, color);
    });

    editor.addEventListener("mousedown", function() {
        setTimeout(() => editor.focus(), 0);
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const editor = document.getElementById('editor');
    const textarea = document.querySelector('textarea[name="description"]');
    const form = document.querySelector('.new-campaign-form');

    form.addEventListener('submit', function() {
        textarea.value = editor.innerHTML;
    });
});


document.getElementById('image_raffle').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const fileName = document.querySelector('.file-name');
    const fileImage = document.querySelector('.file-image');

    if (file) {
        fileName.textContent = file.name;

        const reader = new FileReader();
        reader.onload = function(e) {
            fileImage.style.backgroundImage = `url(${e.target.result})`;
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('image_raffle_galery').addEventListener('change', function(event) {
    const files = event.target.files;
    const fileNameGalery = document.querySelector('.file-name-galery');
    const fileImageGalery = document.querySelector('.file-image-galery');

    let fileNames = '';
    fileImageGalery.innerHTML = ''; 
    Array.from(files).forEach((file, index) => {
        fileNames += file.name + (index < files.length - 1 ? ', ' : '');

        const reader = new FileReader();
        reader.onload = function(e) {
            const imgDiv = document.createElement('div');
            imgDiv.classList.add('file-image-galery-item');
            imgDiv.style.backgroundImage = `url(${e.target.result})`;
            imgDiv.style.width = '120px'; 
            imgDiv.style.height = '100px'; 
            imgDiv.style.backgroundSize = 'cover';
            imgDiv.style.margin = '5px';
            fileImageGalery.appendChild(imgDiv);
        };
        reader.readAsDataURL(file);
    });

    fileNameGalery.textContent = fileNames;
});

document.addEventListener('DOMContentLoaded', function() {
    const optionBuyInput = document.getElementById('option_buy');
    const optionBuyError = document.getElementById('option-buy-error');

    optionBuyInput.addEventListener('input', function() {
        const value = optionBuyInput.value;
        const valuesArray = value.split(',').map(v => v.trim()).filter(v => v !== '');

        if (valuesArray.length === 6) {
            optionBuyError.textContent = '';
            optionBuyInput.value = valuesArray.join(', ');
        } else {
            optionBuyError.textContent = 'Por favor, insira exatamente 6 valores separados por vírgula e espaço.';
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const rankingCheckbox = document.getElementById('ranking');
    const rankingPhraseInput = document.querySelector('input[name="ranking_phrase"]');

    rankingCheckbox.addEventListener('change', function() {
        if (this.checked) {
            rankingPhraseInput.style.display = 'block';
        } else {
            rankingPhraseInput.style.display = 'none';
        }
    });

    const rankingDiaryCheckbox = document.getElementById('ranking_diary');
    const rankingDiaryPhraseInput = document.querySelector('input[name="ranking_diary_phrase"]');

    rankingDiaryCheckbox.addEventListener('change', function() {
        if (this.checked) {
            rankingDiaryPhraseInput.style.display = 'block';
        } else {
            rankingDiaryPhraseInput.style.display = 'none';
        }
    });

    if (!rankingCheckbox.checked) {
        rankingPhraseInput.style.display = 'none';
    }

    if (!rankingDiaryCheckbox.checked) {
        rankingDiaryPhraseInput.style.display = 'none';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.nav-bar-new-campaign button');
    const sections = {
        'btn-setting': document.querySelector('.data-campaign'),
        'btn-customize': document.querySelector('.images-campaign'),
        'btn-customize-2': document.querySelector('.preference-campaign'),
        'btn-social-media': document.querySelector('.promotion-campaign'),
        'btn-track': document.querySelector('.draw_titles')
    };

    function hideAllSections() {
        for (let key in sections) {
            sections[key].style.display = 'none';
        }
    }

    function removeActiveClass() {
        buttons.forEach(button => {
            button.style.borderRight = 'none';
        });
    }

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            hideAllSections();
            removeActiveClass();
            const sectionClass = button.className.split(' ')[0];
            sections[sectionClass].style.display = 'block';
            button.style.borderRight = 'solid 3px #0D6EFD';
        });
    });

    hideAllSections();
    sections['btn-setting'].style.display = 'block';
    document.querySelector('.btn-setting').style.borderRight = 'solid 3px #0D6EFD';
});

document.addEventListener('DOMContentLoaded', function() {
    const typeRaffleSelect = document.querySelector('select[name="type_raffle"]');
    const optionBuyInput = document.getElementById('option_buy');
    const biggerSmallerTitleInput = document.getElementById('bigger_smaller_title');
    const biggerSmallerTitleLabel = document.querySelector('.bigger_smaller_title');
    const biggerSmallerTitleDiaryInput = document.getElementById('bigger_smaller_title_diary');
    const biggerSmallerTitleDiaryLabel = document.querySelector('.bigger_smaller_title_diary');
    const drawTitlesInput = document.getElementById('draw_titles');
    const awardTitlesInput = document.getElementById('award_titles');
    const qtdNumbersInput = document.querySelector('input[name="qtd_numbers"]');
    const qtdNumbersLabel = document.querySelector('.label-qtd-numbers');
    const form = document.querySelector('.new-campaign-form');
    const msgRequired = document.querySelector('.msg-required');
    const btnTrack = document.querySelector('.btn-track');
    const biggerSmallerToggleLabels = document.querySelectorAll('.bigger_smaller_toggle');
    const qtdMax = document.querySelector('.qtd_max');

    function updateFields() {
        const selectedValue = typeRaffleSelect.value;

        optionBuyInput.style.display = '';
        biggerSmallerTitleInput.style.display = '';
        biggerSmallerTitleLabel.style.display = '';
        biggerSmallerTitleDiaryInput.style.display = '';
        biggerSmallerTitleDiaryLabel.style.display = '';
        drawTitlesInput.style.display = '';
        awardTitlesInput.style.display = '';
        qtdNumbersInput.type = 'number';
        qtdNumbersInput.max = '';
        btnTrack.style.display = '';
        qtdNumbersLabel.style.display = '';
        biggerSmallerToggleLabels.forEach(label => label.style.display = '');
        qtdNumbersInput.max = '10000000';
        qtdMax.max = '20000';

        if (selectedValue === 'Normal' || selectedValue === 'Automática') {
            qtdNumbersInput.min = '100';
        } else {
            qtdNumbersInput.min = '1';
        }

        if (selectedValue === 'Normal' || selectedValue === 'Fazendinha') {
            optionBuyInput.style.display = 'none';
            biggerSmallerTitleInput.style.display = 'none';
            biggerSmallerTitleLabel.style.display = 'none';
            biggerSmallerTitleDiaryInput.style.display = 'none';
            biggerSmallerTitleDiaryLabel.style.display = 'none';
            drawTitlesInput.style.display = 'none';
            awardTitlesInput.style.display = 'none';
            btnTrack.style.display = 'none';
            biggerSmallerToggleLabels.forEach(label => label.style.display = 'none');

            if (selectedValue === 'Normal') {
                qtdNumbersInput.max = '10000';
            } else if (selectedValue === 'Fazendinha') {
                qtdNumbersInput.type = 'hidden';
                qtdNumbersInput.value = '25';
                qtdNumbersLabel.style.display = 'none';
            }
        }
    }

    typeRaffleSelect.addEventListener('change', updateFields);
    updateFields(); 

    form.addEventListener('submit', function(event) {
        let valid = true;
        msgRequired.textContent = '';

        form.querySelectorAll('[required]').forEach(function(input) {
            if (!input.value) {
                valid = false;
            }
        });

        if (!valid) {
            event.preventDefault();
            msgRequired.textContent = 'Por favor, preencha todos os campos obrigatórios.';
        }
    });
});



