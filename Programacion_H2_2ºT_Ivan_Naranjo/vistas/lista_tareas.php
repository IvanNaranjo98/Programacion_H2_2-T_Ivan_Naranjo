<?php
// Iniciar sesión si no está iniciada
session_start();

// Verificar si el usuario no está logueado, redirigir al inicio de sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php"); // Si no está logueado, redirige a login
    exit(); // Detiene la ejecución del script
}

// Incluir el controlador de tareas
require('../controllers/controlador_tareas.php');

// Obtener las tareas del usuario autenticado
$usuario_id = $_SESSION['usuario_id']; // Obtener el ID del usuario logueado desde la sesión
$tareas = obtenerTareas($usuario_id); // Obtener todas las tareas del usuario

// Función para marcar una tarea como completada
if (isset($_GET['completar'])) { // Si la URL contiene el parámetro 'completar'
    $tarea_id = $_GET['completar']; // Obtener el ID de la tarea desde la URL
    completarTarea($tarea_id); // Llamar a la función para marcar la tarea como completada
    header("Location: lista_tareas.php"); // Redirigir de nuevo a la lista de tareas
    exit(); // Detener la ejecución del script
}

// Función para eliminar una tarea
if (isset($_GET['eliminar'])) { // Si la URL contiene el parámetro 'eliminar'
    $tarea_id = $_GET['eliminar']; // Obtener el ID de la tarea desde la URL
    eliminarTarea($tarea_id); // Llamar a la función para eliminar la tarea
    header("Location: lista_tareas.php"); // Redirigir de nuevo a la lista de tareas
    exit(); // Detener la ejecución del script
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <!-- Agregar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Mis Tareas</h2>
        <!-- Botón para agregar una nueva tarea -->
        <a href="agregar_tarea.php" class="btn btn-success mb-3">Agregar Nueva Tarea</a>

        <!-- Mostrar las tareas -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($tareas) > 0): ?> <!-- Verificar si hay tareas -->
                    <?php foreach ($tareas as $tarea): ?> <!-- Iterar sobre las tareas -->
                        <tr>
                            <td><?php echo htmlspecialchars($tarea['descripcion']); ?></td> <!-- Mostrar la descripción de la tarea -->
                            <td>
                                <?php echo $tarea['completada'] ? 'Completada' : 'Pendiente'; ?> <!-- Mostrar el estado de la tarea -->
                            </td>
                            <td>
                                <?php if (!$tarea['completada']): ?> <!-- Solo mostrar la opción de marcar como completada si la tarea no está completada -->
                                    <a href="lista_tareas.php?completar=<?php echo $tarea['id']; ?>" class="btn btn-warning btn-sm">Marcar como Completada</a>
                                <?php endif; ?>
                                <a href="lista_tareas.php?eliminar=<?php echo $tarea['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a> <!-- Botón para eliminar la tarea -->
                                <!-- Botón de Editar -->
                                <a href="agregar_tarea.php?id=<?php echo $tarea['id']; ?>" class="btn btn-info btn-sm">Editar</a> <!-- Botón para editar la tarea -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">No tienes tareas pendientes.</td> <!-- Si no hay tareas, mostrar este mensaje -->
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Botón para cerrar sesión -->
        <a href="logout.php" class="btn btn-secondary">Cerrar Sesión</a>
    </div>

    <!-- Agregar JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>