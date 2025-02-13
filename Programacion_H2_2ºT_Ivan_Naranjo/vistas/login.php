<?php
// Iniciar sesión si no está iniciada
session_start();

// Incluir controlador de usuarios
include('../controllers/controlador_usuarios.php');

// Procesar el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // Si el formulario fue enviado
    $correo = $_POST['correo'];  // Obtener el correo desde el formulario
    $contrasena = $_POST['contrasena'];  // Obtener la contraseña desde el formulario

    // Verificar las credenciales del usuario
    $usuario = verificarCredenciales($correo, $contrasena);

    // Si las credenciales son correctas
    if ($usuario) {
        // Almacenar los datos del usuario en la sesión
        $_SESSION['usuario_id'] = $usuario['id']; 
        $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
        
        // Redirigir al usuario a la lista de tareas
        header("Location: lista_tareas.php");
        exit();  // Detener la ejecución del script para evitar que se siga procesando
    } else {
        // Si las credenciales son incorrectas, mostrar un mensaje de error
        $error = "Credenciales incorrectas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Agregar Bootstrap para el diseño de la página -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Iniciar Sesión</h2>

        <!-- Mostrar mensaje de error si las credenciales son incorrectas -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Formulario de inicio de sesión -->
        <form method="POST">
            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            <!-- Enlace para registrar un nuevo usuario -->
            <a href="registro.php" class="btn btn-secondary">Registrar</a>
        </form>
    </div>

    <!-- Agregar JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>