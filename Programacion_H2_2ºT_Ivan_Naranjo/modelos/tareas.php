<?php
// Definimos una clase ModeloTareas que va a gestionar todas las operaciones relacionadas con las tareas
class ModeloTareas {
    private $conexion;  // Variable privada que almacenará la conexión a la base de datos

    // El constructor recibe la conexión a la base de datos y la asigna a la propiedad $conexion
    public function __construct($conexion) {
        $this->conexion = $conexion;  // Guardamos la conexión en el objeto
    }

    // Obtener todas las tareas de un usuario según su ID
    public function obtenerTareas($usuario_id) {
        // Preparamos la consulta para obtener todas las tareas asociadas a un usuario
        $stmt = $this->conexion->prepare("SELECT * FROM tareas WHERE usuario_id = ?");
        $stmt->bind_param("i", $usuario_id);  // "i" significa que vamos a pasar un parámetro entero
        $stmt->execute();  // Ejecutamos la consulta
        return $stmt->get_result();  // Devolvemos el resultado de la consulta
    }

    // Obtener una tarea específica por su ID y el ID del usuario
    public function obtenerTareaPorId($tarea_id, $usuario_id) {
        // Preparamos la consulta para obtener una tarea por su ID y el ID del usuario
        $stmt = $this->conexion->prepare("SELECT * FROM tareas WHERE id = ? AND usuario_id = ?");
        $stmt->bind_param("ii", $tarea_id, $usuario_id);  // "ii" significa que pasamos dos parámetros enteros
        $stmt->execute();  // Ejecutamos la consulta
        return $stmt->get_result()->fetch_assoc();  // Devolvemos la tarea si existe o false si no se encuentra
    }

    // Agregar una nueva tarea
    public function agregarTarea($usuario_id, $descripcion) {
        // Preparamos la consulta para insertar una nueva tarea en la base de datos
        $stmt = $this->conexion->prepare("INSERT INTO tareas (usuario_id, descripcion) VALUES (?, ?)");
        $stmt->bind_param("is", $usuario_id, $descripcion);  // "is" significa que pasamos un parámetro entero y un string
        return $stmt->execute();  // Ejecutamos la consulta y devolvemos el resultado (true si se insertó correctamente)
    }

    // Marcar una tarea como completada
    public function marcarTareaCompletada($tarea_id) {
        // Preparamos la consulta para actualizar el estado de la tarea y marcarla como completada (completada = 1)
        $stmt = $this->conexion->prepare("UPDATE tareas SET completada = 1 WHERE id = ?");
        $stmt->bind_param("i", $tarea_id);  // "i" significa que pasamos un parámetro entero
        return $stmt->execute();  // Ejecutamos la consulta y devolvemos el resultado
    }

    // Eliminar una tarea
    public function eliminarTarea($tarea_id) {
        // Preparamos la consulta para eliminar una tarea por su ID
        $stmt = $this->conexion->prepare("DELETE FROM tareas WHERE id = ?");
        $stmt->bind_param("i", $tarea_id);  // "i" significa que pasamos un parámetro entero
        return $stmt->execute();  // Ejecutamos la consulta y devolvemos el resultado
    }

    // Actualizar la descripción de una tarea
    public function actualizarTarea($tarea_id, $usuario_id, $descripcion) {
        // Preparamos la consulta para actualizar la descripción de una tarea específica
        $stmt = $this->conexion->prepare("UPDATE tareas SET descripcion = ? WHERE id = ? AND usuario_id = ?");
        $stmt->bind_param("sii", $descripcion, $tarea_id, $usuario_id);  // "sii" significa que pasamos un string y dos enteros
        return $stmt->execute();  // Ejecutamos la consulta y devolvemos el resultado
    }
}
?>