<?php
// Incluir archivo de conexión con la base de datos
include('../config/conexion.php');

// Función para obtener las tareas de un usuario específico
function obtenerTareas($usuario_id) {
    global $pdo;  // Usamos la conexión PDO global definida en el archivo de conexión
    // Preparamos la consulta para obtener todas las tareas de un usuario ordenadas por estado de completado (ascendente)
    $stmt = $pdo->prepare("SELECT * FROM tareas WHERE usuario_id = ? ORDER BY completada ASC");
    $stmt->execute([$usuario_id]);  // Ejecutamos la consulta pasando el id del usuario
    return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Retornamos todas las filas encontradas como un array asociativo
}

// Función para agregar una nueva tarea
function agregarTarea($usuario_id, $descripcion) {
    global $pdo;  // Usamos la conexión PDO global
    // Preparamos la consulta para insertar una nueva tarea en la base de datos
    $stmt = $pdo->prepare("INSERT INTO tareas (usuario_id, descripcion) VALUES (?, ?)");
    $stmt->execute([$usuario_id, $descripcion]);  // Ejecutamos la consulta pasando el id del usuario y la descripción de la tarea
}

// Función para marcar una tarea como completada
function completarTarea($tarea_id) {
    global $pdo;  // Usamos la conexión PDO global
    // Preparamos la consulta para actualizar el estado de completada a 1 (completada) en la tarea
    $stmt = $pdo->prepare("UPDATE tareas SET completada = 1 WHERE id = ?");
    $stmt->execute([$tarea_id]);  // Ejecutamos la consulta pasando el id de la tarea a completar
}

// Función para eliminar una tarea
function eliminarTarea($tarea_id) {
    global $pdo;  // Usamos la conexión PDO global
    // Preparamos la consulta para eliminar la tarea de la base de datos
    $stmt = $pdo->prepare("DELETE FROM tareas WHERE id = ?");
    $stmt->execute([$tarea_id]);  // Ejecutamos la consulta pasando el id de la tarea a eliminar
}

// Función para obtener una tarea por su ID y usuario
function obtenerTareaPorId($tarea_id, $usuario_id) {
    global $pdo;  // Usamos la conexión PDO global
    // Preparamos la consulta para obtener una tarea específica de un usuario
    $stmt = $pdo->prepare("SELECT * FROM tareas WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$tarea_id, $usuario_id]);  // Ejecutamos la consulta pasando el id de la tarea y el id del usuario
    return $stmt->fetch(PDO::FETCH_ASSOC);  // Devuelve la tarea encontrada o false si no existe
}

// Función para actualizar una tarea
function actualizarTarea($tarea_id, $usuario_id, $descripcion) {
    global $pdo;  // Usamos la conexión PDO global
    // Preparamos la consulta para actualizar la descripción de una tarea solo si pertenece al usuario indicado
    $stmt = $pdo->prepare("UPDATE tareas SET descripcion = ? WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$descripcion, $tarea_id, $usuario_id]);  // Ejecutamos la consulta pasando la nueva descripción, id de la tarea e id del usuario
}
?>