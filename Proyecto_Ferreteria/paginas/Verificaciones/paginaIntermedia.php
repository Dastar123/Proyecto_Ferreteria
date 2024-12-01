<?php

// Incluir archivos necesarios para consultas, conexiones y validaciones
require_once '../Consultas/consultas.php';
require_once '../Consultas/conexiones.php';
require_once 'validaciones.php';

// Verificar si la solicitud es POST para procesar acciones específicas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'] ?? null; // Obtener la acción enviada por el formulario

    // Procesar la acción según su valor
    switch ($accion) {
        case 'registrar_usuario':
            // Obtener los datos del usuario
            $nombre = $_POST['name'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            $confirmPassword = $_POST['confirm_password'] ?? null;
            $errores = [];

            // Validar el nombre del usuario
            if (validarDato('string', $nombre) !== true) {
                $errores[] = "El nombre es inválido.";
            }

            // Validar el correo electrónico
            if (validarDato('email', $email) !== true) {
                $errores[] = "El correo es inválido."; // Agrega el mensaje de error devuelto por la validación
            }

            // Validar la contraseña
            if (validarDato('string', $password) !== true) {
                $errores[] = "La contraseña es inválida.";
            }

            //Valido que las contraseñas sean iguales
            if ($password != $confirmPassword) {
                $errores[] = "Las contraseñas no coinciden";
            }

            // Si hay errores, redirigir de vuelta con los errores
            if (!empty($errores)) {
                // Redirigir a la página de registro con los errores en la URL
                header("Location: ../Interfaces/registro.php?errores=" . urlencode(implode(", ", $errores)));
                exit;
            }

            // Crear el usuario
            $usuarioCreado = crearUsuario($nombre, $email, $password);
            exit;

        case 'verificar_usuario':
            // Captura los datos del formulario
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            $checkbox = isset($_POST['admin']);

            // Validar si el correo existe
            if ($checkbox !== true) {
                if (verificarExisteUsuario($email, $password)) {
                    // Aquí puedes verificar la contraseña o redirigir a otra página
                    header("Location: ../Interfaces/catalogo.php");
                    exit();
                } else {
                    // Si el usuario no existe
                    header("Location: ../Interfaces/inicioSesion.php?error=Credenciales+inválidas");
                }
            } elseif ($checkbox == true) {
                if (verificarExisteAdministrador($email, $password)) {
                    // Aquí puedes verificar la contraseña o redirigir a otra página
                    header("Location: ../Interfaces/catalogoAdmin.php");
                    exit();
                } else {
                    // Si el usuario no existe
                    header("Location: ../Interfaces/inicioSesion.php?error=Credenciales+inválidas");
                }
            }
            exit;

        case 'agregar_producto':
            // Validar los campos del producto
            $nombre = $_POST['product_name'] ?? null;
            $descripcion = $_POST['description'] ?? null;
            $precio = $_POST['price'] ?? null;
            $imagen = $_FILES['image'] ?? null;
            $errores = [];

            // Validación del nombre del producto
            if (validarDato('string', $nombre) !== true) {
                $errores[] = "El nombre del producto es inválido.";
            }

            // Validación de la descripción
            if (validarDato('string', $descripcion) !== true) {
                $errores[] = "La descripción del producto es inválida.";
            }

            // Validación del precio
            if (validarDato('numero', $precio) !== true) {
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

            // Crear el producto si no hay errores
            $productoCreado = crearProducto($nombre, $descripcion, $precio, $imagen);
            exit;

        case 'eliminar_producto':

            // Obtener el ID del producto
            $id = $_POST['id'] ?? null;

            // Verificar si el ID es válido
            if (!validarDato('numero', $id)) {
                header("Location: ../Interfaces/catalogoAdmin.php?error=ID+de+producto+inválido.");
                exit;
            }

            // Eliminar el producto usando la función que creamos
            $productoEliminado = eliminarProducto($id);

            if ($productoEliminado) {
                // Redirigir al catálogo con un mensaje de éxito
                header("Location: ../Interfaces/catalogoAdmin.php?exito=Producto+eliminado+con+éxito.");
                exit;
            } else {
                // Redirigir con mensaje de error si no se pudo eliminar el producto
                header("Location: ../Interfaces/catalogoAdmin.php?error=Hubo+un+error+al+eliminar+el+producto.");
                exit;
            }

        case 'modificar_producto':
            if (isset($_POST['id'])) {
                $id = intval($_POST['id']); // Asegúrate de convertir el ID a entero

                // Redirige a la interfaz de modificación con el ID del producto
                header("Location: ../Interfaces/modificarProducto.php?id=$id");
                exit;
            } else {
                header("Location: ../Interfaces/catalogoAdmin.php?error=ID+no+especificado+para+modificación.");
                exit;
            }
            break;

        case 'confirmar_modificacion':
            if (isset($_POST['id'])) {
                $id = intval($_POST['id']); // Asegúrate de convertir el ID a entero
                $nombre = $_POST['product_name'] ?? null;
                $descripcion = $_POST['description'] ?? null;
                $precio = $_POST['price'] ?? null;
                $imagen = $_FILES['image'] ?? null;

                // Obtener la imagen actual si no se envió una nueva
                $imagenActual = $_POST['current_image'] ?? null;

                // Validar los datos del producto
                $errores = [];

                if (validarDato('string', $nombre) !== true) {
                    $errores[] = "El nombre del producto es inválido.";
                }

                if (validarDato('string', $descripcion) !== true) {
                    $errores[] = "La descripción del producto es inválida.";
                }

                if (validarDato('numero', $precio) !== true) {
                    $errores[] = "El precio debe ser un número positivo.";
                }

                // Validación de la imagen (solo si se ha subido una nueva)
                if ($imagen && !validarImagen($imagen)) {
                    $errores[] = "La imagen es inválida o no se subió correctamente.";
                }

                // Si hay errores, redirigir de vuelta al formulario con los errores
                if (!empty($errores)) {
                    // Redirigir a modificarProducto.php con los errores en la URL
                    header("Location: ../Interfaces/modificarProducto.php?id=$id&errores=" . urlencode(implode(", ", $errores)));
                    exit;  // Asegurarse de que el script no continúe
                }

                // Si no hay errores, procesar la actualización del producto
                if ($imagen && $imagen['error'] == 0) {
                    // Se proporciona una nueva imagen
                    $productoModificado = modificarProducto($id, $nombre, $descripcion, $precio, $imagen);
                } else {
                    // No se proporciona una nueva imagen, se mantiene la actual
                    $productoModificado = modificarProducto($id, $nombre, $descripcion, $precio, $imagenActual);
                }

                // Verificar si el producto fue modificado exitosamente
                if ($productoModificado) {
                    // Redirigir a la página de éxito (catalogoAdmin.php en este caso)
                    header("Location: ../Interfaces/catalogoAdmin.php?exito=Producto+modificado+exitosamente.");
                } else {
                    // Si algo falló en la modificación, redirigir de vuelta a la página de modificar producto con un mensaje de error
                    header("Location: ../Interfaces/modificarProducto.php?id=$id&error=Hubo+un+error+al+modificar+el+producto.");
                }
                exit;  // Asegurarse de que el script no continúe
            } else {
                header("Location: ../Interfaces/catalogoAdmin.php?error=ID+no+especificado+para+modificación.");
                exit;
            }
            break;

        default:
            // Si no se reconoce la acción, redirigir a una página de error
            header("Location: error.php");
            break;
    }
}