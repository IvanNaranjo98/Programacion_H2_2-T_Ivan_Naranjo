<?php
// Iniciar sesión si no está iniciada
session_start();  // Inicia la sesión para poder acceder a las variables de sesión y gestionarlas

// Incluir controlador de usuarios
require('../controllers/controlador_usuarios.php');  // Incluye el controlador que tiene las funciones para manejar usuarios (registro, login, etc.)

// Procesar el formulario de registro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // Verifica si el formulario se ha enviado con el método POST
    $nombre_usuario = $_POST['nombre_usuario'];  // Obtiene el nombre de usuario desde el formulario
    $correo = $_POST['correo'];  // Obtiene el correo desde el formulario
    $contrasena = $_POST['contrasena'];  // Obtiene la contraseña desde el formulario

    // Registrar el usuario
    registrarUsuario($nombre_usuario, $correo, $contrasena);  // Llama a la función para registrar al usuario en la base de datos

    // Redirigir a la página de login
    header("Location: login.php");  // Redirige a la página de inicio de sesión después de registrarse
    exit();  // Detiene la ejecución del script para evitar que se sigan ejecutando más líneas de código
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <!-- Agregar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Registrarse</h2>

        <!-- Formulario de registro -->
        <form method="POST">
            <div class="mb-3">
                <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>  <!-- Campo para el nombre de usuario -->
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>  <!-- Campo para el correo electrónico -->
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" required>  <!-- Campo para la contraseña -->
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>  <!-- Botón para enviar el formulario -->
            <a href="login.php" class="btn btn-secondary">Iniciar Sesión</a>  <!-- Enlace para ir a la página de inicio de sesión -->
        </form>
    </div>

    <!-- Agregar JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

