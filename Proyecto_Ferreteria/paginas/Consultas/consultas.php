<?php

require_once 'conexiones.php';

/**
 * Función para crear un nuevo usuario.
 *
 * Inserta un nuevo usuario en la tabla `cliente` si el correo electrónico no está registrado.
 *
 * @param string $nombre Nombre del usuario.
 * @param string $email Correo electrónico del usuario.
 * @param string $pass Contraseña del usuario.
 * @return bool Retorna `true` si el usuario fue creado exitosamente, `false` si el correo ya existe o hay un error.
 */
function crearUsuario($nombre, $email, $pass) {
    $conn = conexion();

    // Verifica si el correo ya existe
    if (verificarExisteUsuario($email)) {
        apagar($conn);
        return false; // El correo ya está registrado
    }

    // Inserta el nuevo usuario
    $query = $conn->prepare("INSERT INTO cliente (nombre, email, pass) VALUES (?, ?, ?)");
    $query->bind_param("sss", $nombre, $email, $pass);

    $resultado = $query->execute(); // Ejecuta la consulta
    $query->close();
    apagar($conn); // Cierra la conexión

    return $resultado; // Retorna true si la inserción fue exitosa
}

/**
 * Función para verificar si un usuario existe.
 *
 * Busca un usuario en la base de datos por su correo electrónico.
 *
 * @param string $email Correo electrónico del usuario.
 * @return bool Retorna `true` si el usuario existe, `false` si no.
 */
function verificarExisteUsuario($email) {
    $conn = conexion();

    // Consulta para buscar el correo
    $query = $conn->prepare("SELECT id FROM cliente WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $resultado = $query->get_result();

    $existe = $resultado->num_rows > 0; // Si hay filas, el usuario existe

    $query->close();
    apagar($conn); // Cierra la conexión

    return $existe;
}

/**
 * Función para verificar si un administrador existe.
 *
 * Busca un administrador en la base de datos por su correo electrónico.
 *
 * @param string $email Correo electrónico del administrador.
 * @return bool Retorna `true` si el administrador existe, `false` si no.
 */
function verificarExisteAdministrador($email) {
    $conn = conexion();

    // Consulta para buscar el correo en la tabla administrador
    $query = $conn->prepare("SELECT id FROM administrador WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $resultado = $query->get_result();

    $existe = $resultado->num_rows > 0; // Si hay filas, el administrador existe

    $query->close();
    apagar($conn); // Cierra la conexión

    return $existe;
}

/**
 * Función para eliminar un producto por su ID.
 *
 * Elimina un registro de la tabla `productos` basado en el ID proporcionado.
 *
 * @param int $id El ID del producto a eliminar.
 * @return bool Retorna `true` si la eliminación fue exitosa, `false` en caso contrario.
 */
function eliminarProducto($id) {
    $conn = conexion();

    // Consulta para eliminar el producto
    $query = $conn->prepare("DELETE FROM productos WHERE id = ?");
    $query->bind_param("i", $id); // Vincula el parámetro como entero
    $resultado = $query->execute(); // Ejecuta la consulta

    $query->close();
    apagar($conn); // Cierra la conexión

    return $resultado; // Retorna `true` si se eliminó correctamente
}

/**
 * Función para verificar si un producto ya existe en la base de datos por su nombre.
 *
 * @param string $nombre El nombre del producto a verificar.
 * @return bool Retorna `true` si el producto existe, `false` en caso contrario.
 */
function verificarProductoPorNombre($nombre) {
    $conn = conexion();

    // Consulta para verificar si el producto existe
    $query = $conn->prepare("SELECT id FROM productos WHERE nombre = ?");
    $query->bind_param("s", $nombre); // Vincula el nombre como un string
    $query->execute();

    $resultado = $query->get_result();
    $existe = $resultado->num_rows > 0; // Si hay filas, el producto existe

    $query->close();
    apagar($conn); // Cierra la conexión

    return $existe;
}

function crearProducto($nombre, $descripcion, $precio, $imagen) {
    // Verifica si el producto ya existe
    if (verificarProductoPorNombre($nombre)) {
        // Verifica si $nombre es un array, si lo es, conviértelo en una cadena
        if (is_array($nombre)) {
            $nombre = implode(", ", $nombre); // Convierte el array a una cadena separada por comas
        }
        // Asegúrate de que el nombre está correctamente escapado para la URL
        $nombre = urlencode($nombre);

        // Redirige de vuelta al formulario con un mensaje de error
        header("Location: ../Interfaces/agregarProducto.php?error=El+producto+con+el+nombre+{$nombre}+ya+existe.");
        exit; // Detiene la ejecución después de la redirección
    }

    // Mover la imagen al directorio deseado en el servidor (por ejemplo, '../../imagenes//')
    $rutaImagen = '../../imagenes///' . basename($imagen['name']);  // Cambié la ruta a '../../imagenes//'

    // Verifica si el directorio 'imagenes' existe, si no, lo crea
    if (!file_exists('../../imagenes//')) {
        mkdir('../../imagenes/', 0777, true);  // Crea la carpeta 'imagenes' si no existe
    }

    // Mover la imagen al servidor
    if (!move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
        // Si no se pudo mover la imagen, redirigir con un error
        header("Location: ../Interfaces/agregarProducto.php?error=Hubo+un+problema+al+guardar+la+imagen.");
        exit;
    }

    // Ahora que la imagen se ha movido correctamente, obtenemos la ruta del archivo
    $conn = conexion();

    // Consulta preparada para insertar un producto, usando la ruta de la imagen
    $query = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, imagen) VALUES (?, ?, ?, ?)");
    $query->bind_param("ssds", $nombre, $descripcion, $precio, $rutaImagen);  // Guardamos la ruta de la imagen

    $resultado = $query->execute(); // Ejecuta la consulta

    $query->close();
    apagar($conn); // Cierra la conexión

    if ($resultado) {
        // Si la inserción fue exitosa, redirigimos con éxito
        header("Location: ../Interfaces/catalogo.php?exito=Producto+agregado+exitosamente.");
        exit;  // Detiene la ejecución después de la redirección
    } else {
        // Redirigir con mensaje de error si hubo un problema en la base de datos
        header("Location: ../Interfaces/agregarProducto.php?error=Hubo+un+error+al+agregar+el+producto.");
        exit;
    }
}

?>