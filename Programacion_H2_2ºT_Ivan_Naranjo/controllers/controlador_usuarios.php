<?php
// Incluir archivo de conexión con la base de datos
include('../config/conexion.php');

// Función para registrar un nuevo usuario
function registrarUsuario($nombre_usuario, $correo, $contrasena) {
    global $pdo;  // Usamos la conexión PDO global definida en el archivo de conexión
    
    // Hash de la contraseña: encriptamos la contraseña del usuario antes de guardarla en la base de datos
    $hashed_contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

    // Preparamos la consulta para insertar un nuevo usuario en la base de datos
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre_usuario, correo, contrasena) VALUES (?, ?, ?)");
    // Ejecutamos la consulta pasando el nombre del usuario, correo y la contraseña encriptada
    $stmt->execute([$nombre_usuario, $correo, $hashed_contrasena]);
}

// Función para verificar las credenciales de inicio de sesión
function verificarCredenciales($correo, $contrasena) {
    global $pdo;  // Usamos la conexión PDO global

    // Preparamos la consulta para buscar un usuario por su correo electrónico
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
    // Ejecutamos la consulta pasando el correo
    $stmt->execute([$correo]);
    // Obtenemos los datos del usuario (si existe)
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificamos si el usuario existe y si la contraseña proporcionada coincide con la almacenada
    if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
        return $usuario;  // Si la contraseña es correcta, devolvemos los datos del usuario
    }
    return null;  // Si no coincide, devolvemos null
}
?>