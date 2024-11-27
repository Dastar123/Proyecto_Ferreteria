<?php
// Incluir la conexión y las funciones necesarias
require_once '../Consultas/consultas.php';
require_once '../Verificaciones/paginaIntermedia.php';

// Verificar si se pasó el ID por GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // Convertir el ID a un número entero

    // Obtener el producto desde la base de datos
    $producto = obtenerProductoPorId($id);

    if ($producto) {
        // Producto encontrado, ahora rellenamos el formulario con los datos del producto
        $nombre = htmlspecialchars($producto['nombre']);
        $descripcion = htmlspecialchars($producto['descripcion']);
        $precio = htmlspecialchars($producto['precio']);
        $imagen = htmlspecialchars($producto['imagen']);
    } else {
        // Si el producto no se encuentra, redirigir a la página de error
        header("Location: ../Interfaces/catalogoAdmin.php?error=Producto+no+encontrado.");
        exit;
    }
} else {
    // Si no se pasa un ID válido, redirigir a la página de error
    header("Location: ../Interfaces/catalogoAdmin.php?error=ID+no+especificado+o+inválido.");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../estilos/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Modificar Producto</title>
</head>

<body>

    <!-- Formulario de modificación del producto -->
    <form class="product-form" action="../Verificaciones/paginaIntermedia.php" method="post" enctype="multipart/form-data">
        <div class="product-container">
            <h2 class="product-title">Modificar Producto</h2>

            <input type="hidden" name="accion" value="confirmar_modificacion">
            <input type="hidden" name="id" value="<?= $producto['id'] ?>"> <!-- Pasamos el ID del producto al formulario -->
            <input type="hidden" name="current_image" value="<?= $producto['imagen'] ?>"> <!-- Imagen actual -->
            
            <!-- Nombre del producto -->
            <label for="product-name" class="product-label">Nombre del Producto</label>
            <input type="text" id="product-name" name="product_name" class="product-input" placeholder="Nombre del producto" value="<?php echo $nombre; ?>" required>

            <!-- Descripción del producto -->
            <label for="description" class="product-label">Descripción</label>
            <textarea id="description" name="description" class="product-textarea" placeholder="Descripción del producto" rows="4" required><?php echo $descripcion; ?></textarea>

            <!-- Precio del producto -->
            <label for="price" class="product-label">Precio</label>
            <input type="number" id="price" name="price" class="product-input" placeholder="Precio" min="0" step="0.01" value="<?php echo $precio; ?>" required>

            <!-- Imagen del producto -->
            <label for="image" class="product-label">Imagen del Producto</label>
            <input type="file" id="image" name="image" class="product-file" accept="image/*">
            <!-- Muestra la imagen actual si existe -->
            <?php if ($producto['imagen']): ?>
                <img src="<?= $producto['imagen'] ?>" alt="Imagen actual del producto" width="100">
            <?php endif; ?>

            <button type="submit" class="product-button">Confirmar Producto</button>
        </div>
    </form>

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