<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../estilos/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Registro</title>
</head>

<body>
    
    <!-- Formulario para registrar a un nuevo usuario -->
    <form class="register-form" action="../Verificaciones/paginaIntermedia.php" method="post">
        <h2 class="register-title">Crea una cuenta</h2>
        
        <!-- Campo oculto que indica la acción que debe realizarse cuando se envía el formulario -->
        <input type="hidden" name="accion" value="registrar_usuario">
        
        <!-- Contenedor para los campos del formulario -->
        <div class="register">
            <input class="register-input" type="text" name="name" id="name" placeholder="Nombre">
            <input class="register-input" type="text" name="email" id="email" placeholder="Correo electrónico">
            <input class="register-input" type="password" name="password" id="password" placeholder="Contraseña">
            <input class="register-input" type="password" name="confirm_password" id="confirm_password"
                placeholder="Confirmar contraseña">
            
            <!-- Botón para enviar el formulario -->
            <button class="register-button" type="submit">Registrarse</button>
            
            <!-- Enlace a la página de inicio de sesión si el usuario ya tiene cuenta -->
            <label class="link" onclick="window.location.href='../Interfaces/inicioSesion.php'">¿Ya tienes una cuenta? Inicia sesión</label>
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