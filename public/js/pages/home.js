document.addEventListener('DOMContentLoaded', (event) => {
    function toggleFaq(faqClass, responseClass) {
        const faq = document.querySelector(faqClass);
        const response = document.querySelector(responseClass);

        faq.addEventListener('click', () => {
            if (response.style.display === 'block') {
                response.style.display = 'none';
            } else {
                response.style.display = 'block';
            }
        });
    }

    toggleFaq('.faq-1', '.response-1');
    toggleFaq('.faq-2', '.response-2');
    toggleFaq('.faq-3', '.response-3');
});
