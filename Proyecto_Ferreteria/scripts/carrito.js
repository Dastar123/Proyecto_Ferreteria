document.addEventListener('DOMContentLoaded', () => {
    let carrito = []; // Cambiado de const a let para poder modificar el array directamente
    const cartModal = document.getElementById('cartModal');
    const cartItems = document.getElementById('cartItems');
    const totalPriceElement = document.getElementById('totalPrice');
    const emptyCartButton = document.getElementById('emptyCartButton');

    // Mostrar modal del carrito
    document.getElementById('view-cart')?.addEventListener('click', () => {
        cartModal.style.display = 'flex';
        actualizarCarrito();
    });

    // Cerrar modal del carrito
    document.getElementById('closeModal')?.addEventListener('click', () => {
        cartModal.style.display = 'none';
    });

    // Añadir productos al carrito
    document.querySelectorAll('.product-button').forEach(button => {
        button.addEventListener('click', (e) => {
            const card = e.target.closest('.product-card');
            const name = card.getAttribute('data-name');
            const price = parseFloat(card.getAttribute('data-price'));
            const img = card.getAttribute('data-img');

            if (!name || isNaN(price) || !img) {
                console.warn('Error: Datos del producto incompletos.');
                return;
            }

            const itemIndex = carrito.findIndex(item => item.name === name);
            if (itemIndex > -1) {
                carrito[itemIndex].quantity += 1;
            } else {
                carrito.push({ name, price, img, quantity: 1 });
            }

            actualizarCarrito();
        });
    });

    // Vaciar carrito
    emptyCartButton?.addEventListener('click', () => {
        if (carrito.length > 0) {
            if (confirm('¿Estás seguro que deseas vaciar el carrito?')) {
                carrito = []; // Vaciar el carrito
                actualizarCarrito();
            }
        } else {
            alert('El carrito ya está vacío.');
        }
    });

    // Actualizar carrito
    function actualizarCarrito() {
        cartItems.innerHTML = ''; // Limpiar lista previa
        let total = 0;

        if (carrito.length === 0) {
            const emptyMessage = document.createElement('p');
            emptyMessage.textContent = 'El carrito está vacío.';
            emptyMessage.style.textAlign = 'center';
            cartItems.appendChild(emptyMessage);
        } else {
            carrito.forEach(item => {
                const li = document.createElement('li');
                li.innerHTML = `
                    <img src="${item.img}" alt="${item.name}">
                    <span>${item.name} - ${item.price.toFixed(2)}€ x ${item.quantity}</span>
                    <button class="remove-item" data-name="${item.name}">Eliminar</button>
                `;
                cartItems.appendChild(li);
                total += item.price * item.quantity;
            });

            // Reasignar eventos a los botones de eliminar
            cartItems.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', (e) => {
                    const name = e.target.getAttribute('data-name');
                    carrito = carrito.filter(item => item.name !== name); // Eliminar producto
                    actualizarCarrito(); // Actualizar la vista
                });
            });
        }

        totalPriceElement.textContent = `Total: ${total.toFixed(2)}€`;
    }
});
