document.addEventListener("DOMContentLoaded", () => {
    
    // Obtiene el input de búsqueda, las tarjetas de productos y el contenedor del catalogo
    const searchInput = document.getElementById("searchInput");
    const productCards = document.querySelectorAll(".product-card");
    const catalogContainer = document.querySelector(".catalog-container");

    // Crear el mensaje que se mostrará si no hay productos que coincidan con la búsqueda
    let noResultsMessage = document.createElement("p");
    noResultsMessage.id = "noResultsMessage";
    noResultsMessage.textContent = "No han encontrado productos con ese nombre.";
    noResultsMessage.style.display = "none"; // Ocultar por defecto
    catalogContainer.appendChild(noResultsMessage); // Añadir el mensaje al contenedor del catálogo

    // Detectar cuando el usuario escribe algo en el campo de búsqueda
    searchInput.addEventListener("input", () => {
        const searchTerm = searchInput.value.toLowerCase();
        let matches = 0; // Contador de coincidencias

        // Recorrer todas las tarjetas de producto
        productCards.forEach(card => {
            const productName = card.getAttribute("data-name").toLowerCase();

            // Comprobar si el nombre del producto incluye el término de búsqueda
            if (productName.includes(searchTerm)) {
                card.style.display = "flex"; // Muestra el producto
                matches++; // Incrementar el contador de coincidencias
            } else {
                card.style.display = "none"; // Si no hay coincidencia, ocultar el producto
            }
        });

        // Si no hay coincidencias, mostrar el mensaje de "No se encontraron productos"
        if (matches === 0) {
            noResultsMessage.style.display = "block",
            noResultsMessage.style.color = "white",
            noResultsMessage.style.fontSize = "20px",
            noResultsMessage.style.margin = "20% auto";
        } else {
            noResultsMessage.style.display = "none"; // Si hay coincidencias, ocultar el mensaje
        }
    });
});