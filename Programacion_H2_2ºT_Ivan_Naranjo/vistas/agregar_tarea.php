<?php
// Iniciar la sesión si no está iniciada, para poder acceder a las variables de sesión
session_start();

// Verificar si el usuario no está logueado. Si no está, lo redirige al inicio de sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");  // Redirige al login
    exit();  // Termina la ejecución del script
}

// Incluir el controlador que maneja las tareas
require('../controllers/controlador_tareas.php');

// Inicializar la variable para la descripción de la tarea
$descripcion = '';
$es_editar = false;  // Variable que indica si estamos editando una tarea o creando una nueva

// Si se pasa un ID de tarea en la URL, se va a cargar la tarea para editarla
if (isset($_GET['id'])) {
    $tarea_id = $_GET['id'];  // Obtener el ID de la tarea desde la URL
    // Recuperamos la tarea desde la base de datos usando el ID de la tarea y el ID del usuario
    $tarea = obtenerTareaPorId($tarea_id, $_SESSION['usuario_id']);
    if ($tarea) {
        $descripcion = $tarea['descripcion'];  // Cargar la descripción de la tarea
        $es_editar = true;  // Indicamos que estamos editando la tarea
    } else {
        // Si no se encuentra la tarea, redirigir a la lista de tareas
        header("Location: lista_tareas.php");
        exit();  // Termina la ejecución si no se encuentra la tarea
    }
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger la descripción de la tarea desde el formulario
    $descripcion = $_POST['descripcion'];
    $usuario_id = $_SESSION['usuario_id'];  // Obtener el ID del usuario desde la sesión

    // Si estamos editando una tarea, se actualiza, si no, se agrega una nueva
    if ($es_editar) {
        actualizarTarea($tarea_id, $usuario_id, $descripcion);  // Actualizar la tarea
    } else {
        agregarTarea($usuario_id, $descripcion);  // Agregar la nueva tarea
    }

    // Redirigir de nuevo a la lista de tareas después de agregar o editar
    header("Location: lista_tareas.php");
    exit();  // Termina la ejecución después de la redirección
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $es_editar ? 'Editar Tarea' : 'Agregar Nueva Tarea'; ?></title>
    <!-- Agregar Bootstrap para darle estilo al formulario -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- Mostrar título dependiendo si estamos editando o agregando una tarea -->
        <h2><?php echo $es_editar ? 'Editar Tarea' : 'Agregar Nueva Tarea'; ?></h2>

        <!-- Formulario para agregar o editar una tarea -->
        <form method="POST" action="">
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción de la Tarea</label>
                <!-- El valor del textarea es la descripción de la tarea, que se muestra si estamos editando -->
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo htmlspecialchars($descripcion); ?></textarea>
            </div>
            <!-- Botón que cambia dependiendo si estamos editando o agregando -->
            <button type="submit" class="btn btn-primary"><?php echo $es_editar ? 'Actualizar Tarea' : 'Agregar Tarea'; ?></button>
            <!-- Botón para cancelar, que redirige a la lista de tareas -->
            <a href="lista_tareas.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <!-- Agregar el JS de Bootstrap para los componentes interactivos -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>