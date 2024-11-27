<?php
// Conexión a la base de datos
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
    <header class="header-admin">
        <div class="menu-admin">
            <h1 class="menu-admin-title">Catálogo de Productos</h1>
            <div class="menu-admin-search">
                <input type="text" placeholder="Buscar productos..." id="searchInput" aria-label="Buscar producto">
            </div>
            <label for="admin">(Eres Admin)</label>
            <div class="menu-admin-buttons">
            <button type="button" onclick="window.location.href='../Interfaces/agregarProducto.php'">Agregar producto</button>
                <button type="button" onclick="window.location.href='../Interfaces/inicioSesion.php'">Cerrar sesión</button>
            </div>
        </div>
    </header>

    <?php
        obtenerProductosAdmin();
    ?>
    
    <script src="../../scripts/barraBusqueda.js"></script>
</body>

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

</html>