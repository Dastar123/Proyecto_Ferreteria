<?php

require_once '../Consultas/consultas.php';
require_once 'validaciones.php';

// Verificar qué acción se está realizando
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'] ?? ''; // Obtener la acción

    switch ($accion) {
        case 'agregar_producto':
            // Validar los campos del producto
            $nombre = $_POST['product_name'] ?? null;
            $descripcion = $_POST['description'] ?? null;
            $precio = $_POST['price'] ?? null;
            $imagen = $_FILES['image'] ?? null;
        
            // Errores de validación
            $errores = [];
        
            // Validación del nombre del producto
            if (!validarDato('string', $nombre)) {
                $errores[] = "El nombre del producto es inválido.";
            }
        
            // Validación de la descripción
            if (!validarDato('string', $descripcion)) {
                $errores[] = "La descripción del producto es inválida.";
            }
        
            // Validación del precio
            if (!validarDato('numero', $precio)) {
                $errores[] = "El precio debe ser un número positivo.";
            }
        
            // Validación de la imagen (solo si se ha subido una)
            if ($imagen && !validarImagen($imagen)) {
                $errores[] = "La imagen es inválida o no se subió correctamente.";
            }
        
            // Si hay errores, redirigir de vuelta al formulario con los errores
            if (!empty($errores)) {
                // Redirigir a agregarProducto.php con los errores en la URL
                header("Location: ../Interfaces/agregarProducto.php?errores=" . urlencode(implode(", ", $errores)));
                exit;  // Asegurarse de que el script no continúe
            }
        
            // Si no hay errores, procesar la creación del producto
            $productoCreado = crearProducto($nombre, $descripcion, $precio, $imagen);
        
            // Verificar si el producto fue creado exitosamente
            if ($productoCreado) {
                // Redirigir a la página de éxito (catalogo.php en este caso)
                header("Location: ../Interfaces/catalogo.php?exito=Producto+agregado+exitosamente.");
            } else {
                // Si algo falló en la creación, redirigir de vuelta a la página de agregar producto con un mensaje de error
                header("Location: ../Interfaces/agregarProducto.php?error=Hubo+un+error+al+agregar+el+producto.");
            }
            exit;  // Asegurarse de que el script no continúe después de la redirección
            break;
        

        case 'registrar_usuario':
            break;

        case 'eliminar_producto':
            break;

        default:
            header("Location: error.php");
            break;
    }
}
?>
