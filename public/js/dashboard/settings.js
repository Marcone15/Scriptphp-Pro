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

    document.querySelector("form").addEventListener("submit", function() {
        let content = editor.innerHTML;
        content = content.replace(/(\n|\r)+$/, '');
        termUseTextarea.value = content;
    });

    editor.addEventListener("mousedown", function() {
        setTimeout(() => editor.focus(), 0);
    });
});




document.addEventListener("DOMContentLoaded", function() {
    function handleFileSelect(input, nameFileDiv, imageViewDiv) {
        const file = input.files[0];
        if (file) {
            nameFileDiv.textContent = file.name;

            const reader = new FileReader();
            reader.onload = function(e) {
                imageViewDiv.style.backgroundImage = `url(${e.target.result})`;
            };
            reader.readAsDataURL(file);
        }
    }

    const uploadImageLogo = document.getElementById("upload-image-logo");
    const nameFileLogo = document.querySelector(".content-image-logo .name-file");
    const imageViewLogo = document.querySelector(".content-image-logo .img-logo-view");

    uploadImageLogo.addEventListener("change", function() {
        handleFileSelect(this, nameFileLogo, imageViewLogo);
    });

    const uploadImageIcon = document.getElementById("upload-image-icon");
    const nameFileIcon = document.querySelector(".content-image-icon .name-file-icon");
    const imageViewIcon = document.querySelector(".content-image-icon .img-icon-view");

    uploadImageIcon.addEventListener("change", function() {
        handleFileSelect(this, nameFileIcon, imageViewIcon);
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const btnSetting = document.querySelector(".btn-setting");
    const btnCustomize = document.querySelector(".btn-customize");
    const btnSocialMedia = document.querySelector(".btn-social-media");
    const btnTrack = document.querySelector(".btn-track");
    const btnGateway = document.querySelector(".btn-gateway");

    const settingsContent = document.querySelector(".settings-content");
    const customizeContent = document.querySelector(".cutomize-content");
    const socialContent = document.querySelector(".social-content");
    const trackContent = document.querySelector(".track-content");
    const gatewayContent = document.querySelector(".gateway-content");

    function showContent(contentToShow) {
        settingsContent.style.display = 'none';
        customizeContent.style.display = 'none';
        socialContent.style.display = 'none';
        trackContent.style.display = 'none';
        if (gatewayContent) {
            gatewayContent.style.display = 'none';
        }

        contentToShow.style.display = 'block';

        btnSetting.style.borderRight = 'none';
        btnCustomize.style.borderRight = 'none';
        btnSocialMedia.style.borderRight = 'none';
        btnTrack.style.borderRight = 'none';
        if (btnGateway) {
            btnGateway.style.borderRight = 'none';
        }

        switch (contentToShow) {
            case settingsContent:
                btnSetting.style.borderRight = '3px solid #0D6EFD';
                break;
            case customizeContent:
                btnCustomize.style.borderRight = '3px solid #0D6EFD';
                break;
            case socialContent:
                btnSocialMedia.style.borderRight = '3px solid #0D6EFD';
                break;
            case trackContent:
                btnTrack.style.borderRight = '3px solid #0D6EFD';
                break;
            case gatewayContent:
                btnGateway.style.borderRight = '3px solid #0D6EFD';
                break;
        }
    }

    btnSetting.addEventListener("click", function() {
        showContent(settingsContent);
    });

    btnCustomize.addEventListener("click", function() {
        showContent(customizeContent);
    });

    btnSocialMedia.addEventListener("click", function() {
        showContent(socialContent);
    });

    btnTrack.addEventListener("click", function() {
        showContent(trackContent);
    });

    if (btnGateway) {
        btnGateway.addEventListener("click", function() {
            showContent(gatewayContent);
        });
    }

    
    showContent(settingsContent);
});

