<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../estilos/style.css">
    <title>Registro</title>
</head>

<body>
    <form class="form" action="../Verificaciones/paginaIntermedia.php" method="post">
        <h2 class="register-title">Crea una cuenta</h2>
        <div class="register">
            <input type="hidden" name="accion" value="registrar_usuario">
            <input class="register-input" type="text" name="name" id="name" placeholder="Nombre">
            <input class="register-input" type="text" name="email" id="email" placeholder="Correo electrónico">
            <input class="register-input" type="password" name="password" id="password" placeholder="Contraseña">
            <input class="register-input" type="password" name="confirm_password" id="confirm_password"
                placeholder="Confirmar contraseña">
            <button class="register-button" type="submit">Registrarse</button>
            <label class="link" onclick="window.location.href='../Interfaces/inicioSesion.php'">¿Ya tienes una cuenta? Inicia sesión</label>
        </div>
    </form>
</body>

</html>