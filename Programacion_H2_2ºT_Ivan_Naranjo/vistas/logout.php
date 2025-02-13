<?php
// Iniciar sesión si no está iniciada
session_start();  // Inicia la sesión para poder acceder a las variables de sesión

// Destruir la sesión
session_unset();  // Elimina todas las variables de sesión
session_destroy();  // Destruye la sesión

// Redirigir a la página de login
header("Location: login.php");  // Redirige al usuario a la página de inicio de sesión
exit();  // Detiene la ejecución del script para evitar que se sigan procesando comandos
?>