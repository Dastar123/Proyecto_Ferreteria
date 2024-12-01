document.addEventListener('DOMContentLoaded', () => {
    let carrito = []; // Usamos let porque el carrito puede cambiar a lo largo del script
    const cartModal = document.getElementById('cartModal'); // Modal del carrito
    const cartItems = document.getElementById('cartItems'); // Contenedor de los elementos del carrito
    const totalPriceElement = document.getElementById('totalPrice'); // Elemento donde se mostrará el total
    const emptyCartButton = document.getElementById('emptyCartButton'); // Botón para vaciar el carrito

    // Mostrar el modal del carrito cuando el usuario hace clic en el icono o botón correspondiente
    document.getElementById('view-cart')?.addEventListener('click', () => {
        cartModal.style.display = 'flex';
        actualizarCarrito();
    });

    // Cerrar el modal cuando el usuario hace clic en el botón de cierre
    document.getElementById('closeModal')?.addEventListener('click', () => {
        cartModal.style.display = 'none';
    });

    // Añadir productos al carrito al hacer clic en el botón de "Añadir al carrito"
    document.querySelectorAll('.product-button').forEach(button => {
        button.addEventListener('click', (e) => {

            // Se obtiene información del producto
            const card = e.target.closest('.product-card');
            const name = card.getAttribute('data-name');
            const price = parseFloat(card.getAttribute('data-price'));
            const img = card.getAttribute('data-img');

            // Comprobar si los datos del producto son válidos
            if (!name || isNaN(price) || !img) {
                console.warn('Error: Datos del producto incompletos.');
                return;
            }

            // Comprobar si el producto ya está en el carrito
            const itemIndex = carrito.findIndex(item => item.name === name);
            if (itemIndex > -1) {
                // Si el producto ya está en el carrito, aumentar la cantidad
                carrito[itemIndex].quantity += 1;
            } else {
                // Si el producto no está en el carrito, agregarlo con cantidad 1
                carrito.push({ name, price, img, quantity: 1 });
            }

            // Actualizar el carrito cada vez que se agrega un producto
            actualizarCarrito();
        });
    });

    // Vaciar el carrito si el usuario confirma la acción
    emptyCartButton?.addEventListener('click', () => {
        if (carrito.length > 0) {
            if (confirm('¿Estás seguro que deseas vaciar el carrito?')) {
                carrito = []; // Vaciar el carrito
                actualizarCarrito();
            }
        } else {
            alert('El carrito ya está vacío.'); // Si el carrito ya está vacío, mostrar mensaje
        }
    });

    // Función para actualizar el carrito (mostrar los productos y el total)
    function actualizarCarrito() {
        cartItems.innerHTML = ''; // Limpiar la lista de productos actual
        let total = 0;

        if (carrito.length === 0) {
            // Si el carrito está vacío, muestra un mensaje
            const emptyMessage = document.createElement('p');
            emptyMessage.textContent = 'El carrito está vacío.';
            emptyMessage.style.textAlign = 'center';
            cartItems.appendChild(emptyMessage);
        } else {
            // Se recorren los productos en el carrito y los muestra
            carrito.forEach(item => {
                const li = document.createElement('li');
                li.innerHTML = `
                    <img src="${item.img}" alt="${item.name}">
                    <span>${item.name} - ${item.price.toFixed(2)}€ x ${item.quantity}</span>
                    <button class="remove-item" data-name="${item.name}">Eliminar</button>
                `;

                cartItems.appendChild(li);
                total += item.price * item.quantity;// Calcula el total
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

        // Mostrar el precio total del carrito
        totalPriceElement.textContent = `Total: ${total.toFixed(2)}€`;
    }
});
