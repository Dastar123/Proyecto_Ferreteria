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
    
    <!-- Encabezado para el catálogo de productos, personalizado para administradores -->
    <header class="header-admin">
        <div class="menu-admin">
            <h1 class="menu-admin-title">Catálogo de Productos</h1>
            
            <!-- Barra de búsqueda para que los administradores busquen productos -->
            <div class="menu-admin-search">
                <input type="text" placeholder="Buscar productos..." id="searchInput" aria-label="Buscar producto">
            </div>
            
            <!-- Indicador de que el usuario es administrador -->
            <label for="admin">(Eres Admin)</label>
            
            <!-- Botones de navegación para los administradores, uno para añadir un producto nuevo al catálogo y otro para cerrar sesión -->
            <div class="menu-admin-buttons">
                <button type="button" onclick="window.location.href='../Interfaces/agregarProducto.php'">Agregar producto</button>
                <button type="button" onclick="window.location.href='../Interfaces/inicioSesion.php'">Cerrar sesión</button>
            </div>
        </div>
    </header>

    <?php
        // Llamamos a la función que obtiene y muestra los productos en el catálogo
        obtenerProductosAdmin();
    ?>
    
    <!-- Enlazamos el script JavaScript para la barra de búsqueda -->
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