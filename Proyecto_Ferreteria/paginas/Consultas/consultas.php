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
function crearUsuario($nombre, $email, $pass)
{
    $conn = conexion();

    // Verifica si el correo ya existe
    if (verificarExisteUsuario($email, $pass)) {
        // Redirigir con mensaje de error si el correo ya está registrado
        header("Location: ../Interfaces/registro.php?error=El+correo+electrónico+ya+está+registrado.");
        apagar($conn);
        return false; // El correo ya está registrado
    }

    // Inserta el nuevo usuario
    $query = $conn->prepare("INSERT INTO cliente (nombre, email, pass) VALUES (?, ?, ?)");
    $query->bind_param("sss", $nombre, $email, $pass);

    $resultado = $query->execute(); // Ejecuta la consulta
    $query->close();
    apagar($conn); // Cierra la conexión

    if ($resultado) {
        // Redirigir a la página de éxito
        header("Location: ../Interfaces/inicioSesion.php?exito=Usuario+registrado+con+éxito.");
    } else {
        // Redirigir con mensaje de error si el correo ya está registrado
        header("Location: ../Interfaces/registro.php?error=El+correo+electrónico+ya+está+registrado.");
    }
}

/**
 * Función para verificar si un usuario existe.
 *
 * Busca un usuario en la base de datos por su correo electrónico.
 *
 * @param string $email Correo electrónico del usuario.
 * @return bool Retorna `true` si el usuario existe, `false` si no.
 */
function verificarExisteUsuario($email, $password)
{
    $conn = conexion();

    // Consulta para buscar el correo
    $query = $conn->prepare("SELECT id FROM cliente WHERE email = ? AND pass = ?");
    $query->bind_param("ss", $email, $password);
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
function verificarExisteAdministrador($email, $password)
{
    $conn = conexion();

    // Consulta para buscar el correo en la tabla administrador
    $query = $conn->prepare("SELECT id FROM administrador WHERE email = ? AND pass = ?");
    $query->bind_param("ss", $email, $password);
    $query->execute();
    $resultado = $query->get_result();

    $existe = $resultado->num_rows > 0; // Si hay filas, el administrador existe

    $query->close();
    apagar($conn); // Cierra la conexión

    return $existe;
}

/**
 * Función para verificar si un producto ya existe en la base de datos por su nombre.
 *
 * @param string $nombre El nombre del producto a verificar.
 * @return bool Retorna `true` si el producto existe, `false` en caso contrario.
 */
function verificarProductoPorNombre($nombre)
{
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

/**
 * Función para crear un producto nuevo.
 *
 * Verifica si el producto ya existe, luego mueve la imagen al servidor y guarda el producto en la base de datos.
 *
 * @param string $nombre Nombre del producto.
 * @param string $descripcion Descripción del producto.
 * @param float $precio Precio del producto.
 * @param array $imagen Información de la imagen del producto.
 * @return void Redirige a la página con el estado de la operación (exitoso o error).
 */
function crearProducto($nombre, $descripcion, $precio, $imagen)
{
    // Verifica si el producto ya existe
    if (verificarProductoPorNombre($nombre)) {
        // Verifica si $nombre es un array, si lo es, lo convierte en una cadena
        if (is_array($nombre)) {
            $nombre = implode(", ", $nombre); // Convierte el array a una cadena separada por comas
        }
        // Asegura de que el nombre está correctamente escapado para la URL
        $nombre = urlencode($nombre);

        // Redirige de vuelta al formulario con un mensaje de error
        header("Location: ../Interfaces/agregarProducto.php?error=El+producto+con+el+nombre+{$nombre}+ya+existe.");
        exit; // Detiene la ejecución después de la redirección
    }

    // Mueve la imagen al directorio deseado en el servidor
    $rutaImagen = '../../imagenes///' . basename($imagen['name']);  // Cambié la ruta a '../../imagenes//'

    // Verifica si el directorio 'imagenes' existe, si no, lo crea
    if (!file_exists('../../imagenes//')) {
        mkdir('../../imagenes/', 0777, true);  // Crea la carpeta 'imagenes' si no existe
    }

    // Mueve la imagen al servidor
    if (!move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
        // Si no se pudo mover la imagen, redirige con un error
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
        header("Location: ../Interfaces/catalogoAdmin.php?exito=Producto+agregado+exitosamente.");
        exit;  // Detiene la ejecución después de la redirección
    } else {
        // Redirigir con mensaje de error si hubo un problema en la base de datos
        header("Location: ../Interfaces/agregarProducto.php?error=Hubo+un+error+al+agregar+el+producto.");
        exit;
    }
}

/**
 * Función para modificar un producto existente.
 *
 * @param int $id El ID del producto a modificar.
 * @param string $nombre El nuevo nombre del producto.
 * @param string $descripcion La nueva descripción del producto.
 * @param float $precio El nuevo precio del producto.
 * @param array|null $imagen El archivo de imagen a modificar (opcional).
 * @return bool Retorna `true` si la modificación fue exitosa, `false` en caso contrario.
 */
function modificarProducto($id, $nombre, $descripcion, $precio, $imagen = null)
{
    $conn = conexion();  // Obtiene la conexión

    // Obtiene la ruta de la imagen actual desde la base de datos
    $query = $conn->prepare("SELECT imagen FROM productos WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $query->bind_result($imagenActual);
    $query->fetch();
    $query->close();

    // Inicializa la ruta final de la imagen
    $rutaImagenFinal = $imagenActual;

    // Si se proporciona una nueva imagen, se procesa
    if ($imagen !== null && $imagen['error'] == 0) {
        // Valida la imagen
        $validacionImagen = validarImagen($imagen);
        if ($validacionImagen !== true) {
            return $validacionImagen; // Si la imagen no es válida, retorna el mensaje de error
        }

        // Elimina la imagen anterior si existe
        if ($imagenActual && file_exists($imagenActual)) {
            unlink($imagenActual); // Elimina el archivo de la imagen anterior
        }

        // Mueve la nueva imagen al directorio
        $rutaImagen = '../../imagenes/' . basename($imagen['name']);  // Establecemos la nueva ruta de la imagen
        if (!move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
            return "Hubo un problema al guardar la imagen.";
        }

        $rutaImagenFinal = $rutaImagen; // Actualiza la ruta final de la imagen
    }

    // Prepara la consulta para actualizar los datos del producto junto con la nueva imagen
    $query = $conn->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, imagen = ? WHERE id = ?");
    $query->bind_param("ssdsi", $nombre, $descripcion, $precio, $rutaImagenFinal, $id); // Vincula los parámetros

    // Ejecuta la consulta
    $resultado = $query->execute();

    $query->close();
    apagar($conn);  // Cierra la conexión

    return $resultado; // Retorna `true` si la actualización fue exitosa, de lo contrario `false`
}

/**
 * Función para eliminar un producto por su ID.
 *
 * Elimina un registro de la tabla `productos` basado en el ID proporcionado.
 *
 * @param int $id El ID del producto a eliminar.
 * @return bool Retorna `true` si la eliminación fue exitosa, `false` en caso contrario.
 */
function eliminarProducto($id)
{
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
 * Función para obtener los productos disponibles para los clientes.
 *
 * Muestra los productos en el catálogo para los clientes, con su nombre, descripción, precio e imagen.
 */
function obtenerProductosClientes()
{
    $conn = conexion(); // Obtiene la conexión

    // Consulta para obtener los productos
    $query = $conn->prepare("SELECT nombre, precio, descripcion, imagen FROM productos");
    $query->execute();

    // Usamos get_result() para obtener un objeto resultante
    $result = $query->get_result();

    if ($result->num_rows > 0) { // Si hay productos disponibles
        echo '<div class="catalog-container">';
        while ($row = $result->fetch_assoc()) { // Muestra cada producto
            echo '
            <div class="product-card" data-name="' . htmlspecialchars($row['nombre']) . '" data-price="' . htmlspecialchars($row['precio']) . '" data-img="' . htmlspecialchars($row['imagen']) . '">
                <img src="' . htmlspecialchars($row['imagen']) . '" alt="Producto">
                <div class="product-info">
                    <h3>' . htmlspecialchars($row['nombre']) . '</h3>
                    <p>' . htmlspecialchars($row['descripcion']) . '</p>
                    <p>Precio: ' . htmlspecialchars($row['precio']) . ' €</p>
                    <button type="button" class="product-button">Agregar al carrito</button>
                </div>
            </div>';
        }
        echo '</div>';
    } else {
        echo '<p class="catalog-container-empty">No hay productos disponibles actualmente.</p>';
    }

    $query->close();
    apagar($conn); // Cierra la conexión
}

/**
 * Función para obtener los productos para el administrador.
 *
 * Muestra los productos en el catálogo para el administrador, con opciones de modificar y eliminar productos.
 */
function obtenerProductosAdmin()
{
    $conn = conexion(); // Obtiene la conexión

    // Consulta para obtener los productos
    $query = $conn->prepare("SELECT id, nombre, precio, descripcion, imagen FROM productos");
    $query->execute();

    // Usamos get_result() para obtener un objeto resultante
    $result = $query->get_result();

    if ($result->num_rows > 0) { // Si hay productos disponibles
        echo '<div class="catalog-container">';
        while ($row = $result->fetch_assoc()) { // Muestra cada producto
            echo '
            <div class="product-card" data-name="' . htmlspecialchars($row['nombre']) . '">
                <img src="' . htmlspecialchars($row['imagen']) . '" alt="Producto">
                <div class="product-info">
                    <h3>' . htmlspecialchars($row['nombre']) . '</h3>
                    <p>' . htmlspecialchars($row['descripcion']) . '</p>
                    <p>Precio: ' . htmlspecialchars($row['precio']) . ' €</p>

                    <div class="product-buttons">
                        <!-- Botón de Eliminar -->
                        <form action="../Verificaciones/paginaIntermedia.php" method="post"">
                            <input type="hidden" name="accion" value="eliminar_producto">
                            <input type="hidden" name="id" value="' . htmlspecialchars($row['id']) . '">
                            <button type="submit" class="product-button">Eliminar</button>
                        </form>

                        <!-- Botón de Modificar -->
                        <form action="../Interfaces/modificarProducto.php" method="post">
                            <input type="hidden" name="accion" value="modificar_producto">
                            <input type="hidden" name="id" value="' . htmlspecialchars($row['id']) . '">
                            <button type="submit" class="product-button">Modificar</button>
                        </form>
                    </div>
                </div>
            </div>';
        }
        echo '</div>';
    } else {
        echo '<p class="catalog-container-empty">No hay productos disponibles actualmente.</p>';
    }

    $query->close();
    apagar($conn); // Cierra la conexión
}

/**
 * Función para obtener un producto por su ID.
 *
 * @param int $id El ID del producto a obtener.
 * @return array|null Retorna un arreglo asociativo con los datos del producto o null si no se encuentra.
 */
function obtenerProductoPorId($id)
{
    $conn = conexion(); // Obtiene la conexión

    // Consulta para obtener el producto por ID
    $query = $conn->prepare("SELECT * FROM productos WHERE id = ?");
    $query->bind_param("i", $id); // Vincula el ID como parámetro entero
    $query->execute();

    $resultado = $query->get_result();

    if ($resultado->num_rows > 0) {
        return $resultado->fetch_assoc(); // Devuelve los detalles del producto
    } else {
        return false; // Si no se encuentra el producto
    }

    $query->close();
    apagar($conn);  // Cierra la conexión
}