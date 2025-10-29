document.addEventListener("DOMContentLoaded", function() {
    const addCommunicationButton = document.querySelector(".add-communication button");
    const addCommunicationField = document.querySelector(".add-communication-field");

    addCommunicationButton.addEventListener("click", function(e) {
        e.preventDefault();
        if (addCommunicationField.style.display === "block") {
            if (document.querySelector(".add-communication textarea").value.trim() === "") {
                alert("Por favor, insira o comunicado.");
            } else {
                document.querySelector(".add-communication form").submit();
            }
        } else {
            addCommunicationField.style.display = "block";
        }
    });

    document.querySelectorAll(".bi-pencil").forEach(editButton => {
        editButton.addEventListener("click", function(e) {
            e.preventDefault();
            const editSpan = this.closest(".ranking-grid").querySelector(".edit-communication");
            if (editSpan.style.display === "block" || editSpan.style.display === "none") {
                editSpan.style.display = editSpan.style.display === "block" ? "none" : "block";
            } else {
                editSpan.style.display = "block";
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
