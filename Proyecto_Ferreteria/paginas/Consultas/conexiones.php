<?php

/**
 * Función para establecer la conexión a la base de datos.
 *
 * Esta función crea una conexión con la base de datos MySQL usando los parámetros definidos.
 * Si la conexión es exitosa, devuelve el objeto de la conexión ($conn).
 *
 * @author Raul
 * @since 1.0
 * @return mysqli Retorna el objeto de conexión mysqli si la conexión es exitosa.
 * @throws Exception Lanza un error si la conexión no se puede establecer.
 */
function conexion()
{
    // Configuración de la conexión
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ferreteria";

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar si la conexión fue exitosa
    if ($conn->connect_error) {
        die("<p class='error'>Conexión fallida: " . $conn->connect_error . "</p>");
    } else {
        return $conn;
    }
}

/**
 * Función para cerrar la conexión a la base de datos.
 *
 * Esta función cierra la conexión a la base de datos. Si la conexión es válida, la cierra,
 * de lo contrario, muestra un mensaje de error indicando que no hay una conexión activa.
 *
 * @param mysqli $conn El objeto de conexión mysqli a cerrar.
 * @return void No retorna ningún valor.
 */
function apagar($conn)
{
    if ($conn) {
        $conn->close();  // Cierra la conexión a la base de datos

    } else {
        echo "<p>No hay una conexión activa para cerrar.</p>";
    }
}

// Llamada a la función para probar la conexión
$con = conexion();

// Llamada a la función para cerrar la conexión
//apagar($con);