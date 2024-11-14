<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.7);
            position: relative;
        }

        .fondo {
            background-image: url(fondo.jpg);
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-size: cover;
            opacity: 0.7;
            z-index: -1;
        }

        h1 {
            text-align: center;
            color: #fff;
            margin-top: 20px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 80%; max-width: 600px;
            text-align: center;
        }

        .close-btn, .empty-cart, .remove-selected {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .close-btn:hover, .empty-cart:hover, .remove-selected:hover {
            background-color: #0056b3;
        }

        .cart-items {
            list-style-type: none;
            padding: 0;
            text-align: left;
            margin-top: 20px;
        }

        .cart-items li {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 15px;
            padding: 10px; border-bottom: 1px solid #ddd;
        }

        .cart-items li img {
            width: 50px; height: 50px;
            object-fit: cover;
            margin-right: 10px;
            border-radius: 5px;
        }

        .total-price {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        #view-cart {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #view-cart:hover {
            background-color: #0056b3;
        }

        .remove-selected {
            display: none; 
            margin-top: 20px;
            background-color: #fe522b;
        }
    </style>
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