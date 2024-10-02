//This file is meant to be used to delete items illustrations
document.addEventListener("DOMContentLoaded", function () {
    let links = document.querySelectorAll("[data-delete]");

    for (let link of links) {
        link.addEventListener("click", function (e) {
            // Prevent navigation (we want to use AJAX instead of using the normal delete event)
            e.preventDefault();
            if (confirm("Voulez-vous vraiment supprimer cet élément ?")) {
                // Send ajax request
                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ "_token": this.dataset.token })
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.parentElement.remove();
                            location.reload();
                        } else {
                            alert(data.error);
                        }
                    })
            }
        });
    }
});