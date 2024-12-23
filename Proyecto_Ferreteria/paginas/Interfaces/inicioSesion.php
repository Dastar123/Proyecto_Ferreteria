<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../estilos/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Inicio Sesión</title>
</head>

<body>

    <!-- Formulario para que los usuarios inicien sesión -->
    <form class="login-form" action="../Verificaciones/paginaIntermedia.php" method="post">
        <h2 class="login-title">Iniciar sesión en Ferretería</h2>
        
        <!-- Campo oculto que indica la acción que debe realizarse cuando se envía el formulario -->
        <input type="hidden" name="accion" value="verificar_usuario">
        
        <div class="login">
            <input class="login-input" type="text" name="email" id="email" placeholder="Correo electrónico">
            <input class="login-input" type="password" name="password" id="password" placeholder="Contraseña">
            
            <!-- Opción para iniciar sesión como administrador -->
            <div class="admin">
                <input class="checkbox" type="checkbox" name="admin" id="admin">
                <label class="admin-check" for="admin">Continuar como administrador</label>
            </div>

            <!-- Botón para enviar el formulario -->
            <button class="login-button" type="submit">Iniciar Sesión</button>
            
            <!-- Enlace a la página de registro si el usuario no tiene cuenta -->
            <label class="link" onclick="window.location.href='../Interfaces/registro.php'">¿No tienes cuenta? Registrate ahora</label>
        </div>
    </form>
    
    <!-- Pie de página con información de copyright y enlaces a redes sociales que se abrirán en una nueva pestaña -->
    <footer>
        <p>&copy; 2024 Tienda de Ferretería. Todos los derechos reservados.</p>
        <div class="social-links">
            <a href="https://www.facebook.com" target="_blank" title="Facebook">
                <i class="fab fa-facebook"></i>
            </a>
            <a href="https://www.twitter.com" target="_blank" title="Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://www.instagram.com" target="_blank" title="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
    </footer>
</body>

</html>