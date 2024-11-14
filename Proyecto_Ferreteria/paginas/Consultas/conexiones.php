<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conexión a Base de Datos</title>

</head>
<body>

<?php

function conexion(){

    $servername = "localhost";  
    $username = "root";       
    $password = "";           
    $dbname = "ferreteriaLombardo";  
    
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    
    if ($conn->connect_error) {
        echo "<p class='error'>Conexión fallida: " . $conn->connect_error . "</p>";
    } else {
        echo "<p class='success'>Conexión exitosa a la base de datos '$dbname'!</p>";
}
 
}

conexion();
 

?>

</body>
</html>
