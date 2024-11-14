<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../estilos/style.css">
    <title>Registro</title>
</head>

<body>
    <form class="form" action="paginaIntermedia.php" method="post">
        <div class="registro">
            <input class="input" type="text" name="name" id="name" placeholder="Nombre">
            <input class="input" type="text" name="email" id="email" placeholder="Correo electrónico">
            <input class="input" type="password" name="password" id="password" placeholder="Contraseña">
            <input class="input" type="password" name="confirm_password" id="confirm_password" placeholder="Confirmar contraseña">
            <button class="button" type="submit">Registrarse</button>
        </div>
    </form>
</body>

</html>