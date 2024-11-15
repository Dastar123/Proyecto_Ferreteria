<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../estilos/style.css">
    <title>Agregar Producto</title>
</head>

<body>
 
<form class="product-form" action="../Verificaciones/paginaIntermedia.php" method="post" enctype="multipart/form-data">
    <div class="product-container">
        <h2 class="product-title">Agregar Producto</h2>
        
        <input type="hidden" name="accion" value="agregar_producto">

        <label for="product-name" class="product-label">Nombre del Producto</label>
        <input type="text" id="product-name" name="product_name" class="product-input" placeholder="Nombre del producto" required>

        <label for="description" class="product-label">Descripción</label>
        <textarea id="description" name="description" class="product-textarea" placeholder="Descripción del producto" rows="4" required></textarea>

        <label for="price" class="product-label">Precio</label>
        <input type="number" id="price" name="price" class="product-input" placeholder="Precio" min="0" step="0.01" required>

        <label for="image" class="product-label">Imagen del Producto</label>
        <input type="file" id="image" name="image" class="product-file" accept="image/*" required>

        <button type="submit" class="product-button">Agregar Producto</button>
    </div>
</form>

</body>

</html>
