<?php

/**
 * Función para validar diferentes tipos de datos.
 *
 * @param string $tipo El tipo de dato a validar (telefono, correo, string, numero, etc.).
 * @param mixed $dato El dato que se desea validar.
 * @return mixed Retorna `true` si el dato es válido o un mensaje de error en caso contrario.
 */
function validarDato($tipo, $dato)
{
    switch ($tipo) {
        case 'telefono':
            // Validación de teléfono (9 o 10 dígitos)
            if (preg_match('/^\d{9,10}$/', $dato)) {
                return true;
            } else {
                return "Formato de número de teléfono incorrecto.";
            }
            
        case 'email':
            // Sanitizar el correo antes de validar
            $dato = filter_var($dato, FILTER_SANITIZE_EMAIL);

            // Validar formato del correo electrónico
            if (filter_var($dato, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return "Formato de correo electrónico incorrecto.";
            }

        case 'string':
            // Elimina etiquetas HTML y espacios en blanco
            $dato = trim(strip_tags($dato));
            if (!empty($dato)) {
                return true;
            } else {
                return "El campo de texto no puede estar vacío o solo contener espacios.";
            }

        case 'numero':
            // Comprueba si es un número y si es positivo
            if (is_numeric($dato) && $dato >= 0) {
                return true;
            } else {
                return "Debe ser un número positivo.";
            }

        case 'url':
            // Validación de URL
            if (filter_var($dato, FILTER_VALIDATE_URL)) {
                return true;
            } else {
                return "URL no válida.";
            }

        case 'fecha':
            // Validación de formato de fecha (YYYY-MM-DD)
            $fechaValida = DateTime::createFromFormat('Y-m-d', $dato);
            if ($fechaValida && $fechaValida->format('Y-m-d') === $dato) {
                return true;
            } else {
                return "Formato de fecha incorrecto. Use YYYY-MM-DD.";
            }

        case 'password':
            // Validación de contraseña (mínimo 8 caracteres, al menos 1 letra y 1 número)
            if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $dato)) {
                return true;
            } else {
                return "La contraseña debe tener al menos 8 caracteres, incluyendo una letra y un número.";
            }

        default:
            return "Tipo de validación no reconocido.";
    }
}

/**
 * Función para validar imágenes.
 *
 * @param array $imagen Información del archivo subida ($_FILES['nombre']).
 * @param array $formatosPermitidos Lista de extensiones permitidas (opcional).
 * @param int $tamanioMaximo Tamaño máximo permitido en bytes (opcional).
 * @return mixed Retorna `true` si la imagen es válida o un mensaje de error en caso contrario.
 */
function validarImagen($imagen)
{
    // Verificar si se ha subido un archivo
    if ($imagen['error'] !== 0) {
        return false; // Error en la carga
    }

    // Verificar tipo de archivo
    $tipoImagen = mime_content_type($imagen['tmp_name']);
    if (!in_array($tipoImagen, ['image/jpeg', 'image/png', 'image/gif'])) {
        return false; // Si no es una imagen válida
    }

    // Verificar tamaño (por ejemplo, no mayor a 2MB)
    if ($imagen['size'] > 2 * 1024 * 1024) { // 2MB
        return false; // Imagen demasiado grande
    }

    return true;
}

?>