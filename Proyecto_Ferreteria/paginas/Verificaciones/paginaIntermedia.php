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
             // Obtener los datos del usuario
            $nombre = $_POST['nombre'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
        
            // Errores de validación
            $errores = [];
        
            // Validar el nombre del usuario
            if (!validarDato('string', $nombre)) {
                $errores[] = "El nombre es inválido.";
            }
        
            // Validar el correo electrónico
            if (!validarDato('email', $email)) {
                $errores[] = "El correo electrónico es inválido.";
            }
        
            // Validar la contraseña
            if (!validarDato('string', $password)) {
                $errores[] = "La contraseña es inválida.";
            }
        
            // Si hay errores, redirigir de vuelta con los errores
            if (!empty($errores)) {
                // Redirigir a la página de registro con los errores en la URL
                header("Location: ../Interfaces/registrarUsuario.php?errores=" . urlencode(implode(", ", $errores)));
                exit;
            }
        
            // Crear el usuario (la contraseña debe ser cifrada antes de insertar)
            $usuarioCreado = crearUsuario($nombre, $email, $password);
        
            if ($usuarioCreado) {
                // Redirigir a la página de éxito
                header("Location: ../Interfaces/catalogo.php?exito=Usuario+registrado+con+éxito.");
            } else {
                // Redirigir con mensaje de error si el correo ya está registrado
                header("Location: ../Interfaces/registro.php?error=El+correo+electrónico+ya+está+registrado.");
            }
            exit;
            break;

        case 'eliminar_producto':   
            // Obtener el ID del producto
            $id = $_POST['id_producto'] ?? null;
        
            // Verificar si el ID es válido
            if (!validarDato('numero', $id)) {
                header("Location: ../Interfaces/catalogo.php?error=ID+de+producto+inválido.");
                exit;
            }
        
            // Eliminar el producto usando la función que creamos
            $productoEliminado = eliminarProducto($id);
        
            if ($productoEliminado) {
                // Redirigir al catálogo con un mensaje de éxito
                header("Location: ../Interfaces/catalogo.php?exito=Producto+eliminado+con+éxito.");
            } else {
                // Redirigir con mensaje de error si no se pudo eliminar el producto
                header("Location: ../Interfaces/catalogo.php?error=Hubo+un+error+al+eliminar+el+producto.");
            }
            exit;
            break; 

        default:
            // Si no se reconoce la acción, redirigir a una página de error
            header("Location: error.php");
            break;
    }
}
?>
