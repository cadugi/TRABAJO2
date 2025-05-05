/* registro inicio */

        // Mostrar el popup si el registro fue exitoso
        document.addEventListener("DOMContentLoaded", function () {
            const popup = document.getElementById("popup");
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get("registro") === "exitoso") {
                popup.style.display = "block"; // Mostrar el popup
                setTimeout(() => {
                    popup.style.display = "none"; // Ocultar el popup después de 3 segundos
                }, 3000);
            }
        });

/* registro fin */