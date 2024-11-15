<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../estilos/style.css">
    <title>Carrito de Compras</title>  
</head>
<body>
    <div class="fondo"></div>
    <h1>Carrito de Compras</h1>

    <button id="view-cart">Ver Carrito</button>

    <div class="modal" id="cartModal">
        <div class="modal-content">
            <h2>Carrito de Compras</h2>
            <ul class="cart-items" id="cartItems">
                <!-- Aquí se agregarán los productos -->
            </ul>
            <div class="total-price" id="totalPrice">Total: 0€</div>
            <button class="close-btn" id="closeModal">Cerrar</button>
            <button class="empty-cart" id="emptyCartButton">Vaciar Carrito</button>
            <button class="remove-selected" id="removeSelectedButton">Eliminar Producto</button>
        </div>
    </div>

    <script>
        let carrito = [];

        document.addEventListener("DOMContentLoaded", () => {
            const cartModal = document.getElementById('cartModal');
            const viewCartButton = document.getElementById('view-cart');
            const cartItemsList = document.getElementById('cartItems');
            const totalPriceElement = document.getElementById('totalPrice');
            const emptyCartButton = document.getElementById('emptyCartButton');
            const removeSelectedButton = document.getElementById('removeSelectedButton');

            // Mostrar carrito
            viewCartButton.addEventListener('click', () => {
                cartItemsList.innerHTML = '';
                let total = 0;
                carrito.forEach((item, index) => {
                    const li = document.createElement('li');
                    const itemTotalPrice = item.price * item.quantity; // Calcular el precio total por item
                    li.innerHTML = `
                        <img src="${item.img}" alt="${item.name}">
                        ${item.name} - Talla: ${item.size} - Cantidad: ${item.quantity} - Precio: ${itemTotalPrice}€
                        <input type="checkbox" id="removeCheckbox${index}" data-index="${index}">
                    `;
                    cartItemsList.appendChild(li);
                    total += itemTotalPrice;
                });
                totalPriceElement.textContent = `Total: ${total}€`;
                cartModal.style.display = 'flex';

                // Ocultar el botón de eliminar al abrir el carrito
                removeSelectedButton.style.display = 'none';
            });

            // Evento para mostrar/ocultar el botón de eliminar
            cartItemsList.addEventListener('change', () => {
                const checkboxes = document.querySelectorAll('.cart-items input[type="checkbox"]');
                const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                removeSelectedButton.style.display = anyChecked ? 'block' : 'none'; // Muestra el botón si hay algún checkbox marcado
            });

            // Cerrar el carrito
            document.getElementById('closeModal').addEventListener('click', () => {
                cartModal.style.display = 'none';
            });

            // Vaciar el carrito
            emptyCartButton.addEventListener('click', () => {
                carrito = [];
                cartItemsList.innerHTML = '';
                totalPriceElement.textContent = 'Total: 0€';
                removeSelectedButton.style.display = 'none';
            });

            // Eliminar productos seleccionados
            removeSelectedButton.addEventListener('click', () => {
                const checkboxes = document.querySelectorAll('.cart-items input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const index = parseInt(checkbox.getAttribute('data-index'));
                        carrito.splice(index, 1);
                    }
                });
                viewCartButton.click(); // Vuelve a abrir el carrito para que se actualice
            });
        });
    </script>
</body>
</html>