<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../estilos/style.css">
    <title>Inicio Sesión</title>
</head>

<body>
    <form class="form" action="../Verificaciones/paginaIntermedia.php" method="post">
        <h2 class="login-title">Iniciar sesión en Ferretería</h2>
        <input type="hidden" name="accion" value="verificar_usuario">
        <div class="login">
            <input class="login-input" type="text" name="email" id="email" placeholder="Correo electrónico" required>
            <input class="login-input" type="password" name="password" id="password" placeholder="Contraseña" required
                minlength="6">
            <button class="login-button" type="submit">Iniciar Sesión</button>
        </div>
    </form>
</body>

</html>