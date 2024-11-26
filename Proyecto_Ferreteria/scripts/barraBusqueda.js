document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchInput");
    const productCards = document.querySelectorAll(".product-card");
    const catalogContainer = document.querySelector(".catalog-container");

    // Crear mensaje de "No se encontraron productos"
    let noResultsMessage = document.createElement("p");
    noResultsMessage.id = "noResultsMessage";
    noResultsMessage.textContent = "No han encontrado productos con ese nombre.";
    noResultsMessage.style.display = "none"; // Ocultar por defecto
    catalogContainer.appendChild(noResultsMessage);

    searchInput.addEventListener("input", () => {
        const searchTerm = searchInput.value.toLowerCase();
        let matches = 0; // Contador de coincidencias

        productCards.forEach(card => {
            const productName = card.getAttribute("data-name").toLowerCase();

            if (productName.includes(searchTerm)) {
                card.style.display = "flex"; // Muestra el producto
                matches++;
            } else {
                card.style.display = "none"; // Oculta el producto
            }
        });

        // Mostrar mensaje si no hay coincidencias
        if (matches === 0) {
            noResultsMessage.style.display = "block",
            noResultsMessage.style.color = "white",
            noResultsMessage.style.fontSize = "20px",
            noResultsMessage.style.margin = "20% auto";
        } else {
            noResultsMessage.style.display = "none";
        }
    });
});