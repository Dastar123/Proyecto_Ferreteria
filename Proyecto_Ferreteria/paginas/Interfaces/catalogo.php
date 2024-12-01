<?php

// Incluimos el archivo que contiene las funciones para consultar la base de datos
require_once '../Consultas/consultas.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../estilos/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Catálogo de Productos</title>
</head>

<body>

    <!-- Encabezado con el nombre del catálogo y las opciones de búsqueda y navegación -->
    <header>
        <div class="menu">
            <h1 class="menu-title">Catálogo de Productos</h1>
            
            <!-- Barra de búsqueda para que los clientes busquen productos -->
            <div class="menu-search">
                <input type="text" placeholder="Buscar productos..." id="searchInput" aria-label="Buscar producto">
            </div>
            
            <!-- Botones de navegación, uno para ver el carrito y otro para cerrar sesión -->
            <div class="menu-buttons">
                <button type="button" id="view-cart">Ver carrito</button>
                <button type="button" onclick="window.location.href='../Interfaces/inicioSesion.php'">Cerrar sesión</button>
            </div>
        </div>
    </header>

    <!-- Modal para mostrar el carrito de compras -->
    <div class="modal" id="cartModal">
        <div class="modal-content">
            <h2>Carrito de Compras</h2>

            <!-- Lista de productos que el usuario ha añadido al carrito -->
            <ul id="cartItems" class="cart-items"></ul>
            <div class="cart-footer">
                <div class="total-price" id="totalPrice">Total: 0€</div>
                <button id="closeModal" class="close-btn">Cerrar</button>
                <button id="emptyCartButton" class="empty-cart">Vaciar Carrito</button>
            </div>
        </div>
    </div>

    <?php
        // Llamamos a la función que obtiene y muestra los productos en el catálogo
        obtenerProductosClientes();
    ?>

    <!-- Enlazamos los scripts JavaScript para el carrito y la barra de búsqueda -->
    <script src="../../scripts/carrito.js"></script>
    <script src="../../scripts/barraBusqueda.js"></script>
    
    <!-- Pie de página con información de copyright y enlaces a redes sociales que se abrirán en una nueva pestaña -->
    <footer>
        <p>&copy; 2024 Tienda de Ferretería. Todos los derechos reservados.</p>
        <div class="social-links">
            <a href="https://www.facebook.com" target="_blank" title="Facebook">
                <i class="fab fa-facebook"></i>
            </a>
            <a href="https://www.twitter.com" target="_blank" title="Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://www.instagram.com" target="_blank" title="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
    </footer>
</body>

</html>