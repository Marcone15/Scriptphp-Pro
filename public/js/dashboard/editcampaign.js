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
});

