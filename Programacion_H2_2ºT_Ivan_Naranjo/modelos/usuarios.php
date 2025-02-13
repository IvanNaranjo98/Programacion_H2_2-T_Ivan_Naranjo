<?php
// Definimos una clase ModeloUsuarios que se encargará de gestionar las operaciones relacionadas con los usuarios
class ModeloUsuarios {
    private $conexion;  // Variable privada para almacenar la conexión a la base de datos

    // El constructor recibe la conexión a la base de datos y la asigna a la propiedad $conexion
    public function __construct($conexion) {
        $this->conexion = $conexion;  // Guardamos la conexión en la propiedad del objeto
    }

    // Verificar si el correo ya está registrado en la base de datos
    public function verificarCorreo($correo) {
        // Preparamos la consulta SQL para buscar un usuario por su correo
        $stmt = $this->conexion->prepare("SELECT * FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);  // "s" significa que estamos pasando un parámetro de tipo string (el correo)
        $stmt->execute();  // Ejecutamos la consulta
        $resultado = $stmt->get_result();  // Obtenemos el resultado de la consulta

        // Si el número de filas es mayor que 0, significa que el correo ya está registrado
        return $resultado->num_rows > 0;  // Devuelve true si el correo existe, de lo contrario, false
    }

    // Registrar un nuevo usuario en la base de datos
    public function registrarUsuario($nombre_usuario, $correo, $contrasena) {
        // Usamos password_hash para encriptar la contraseña antes de almacenarla
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
        
        // Preparamos la consulta SQL para insertar un nuevo usuario
        $stmt = $this->conexion->prepare("INSERT INTO usuarios (nombre_usuario, correo, contrasena) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre_usuario, $correo, $contrasena_hash);  // "sss" significa tres parámetros tipo string
        return $stmt->execute();  // Ejecutamos la consulta y devolvemos el resultado (true si se insertó correctamente)
    }

    // Iniciar sesión verificando el correo y la contraseña
    public function iniciarSesion($correo, $contrasena) {
        // Preparamos la consulta SQL para buscar un usuario por su correo
        $stmt = $this->conexion->prepare("SELECT * FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);  // "s" significa que estamos pasando un parámetro de tipo string (el correo)
        $stmt->execute();  // Ejecutamos la consulta
        $resultado = $stmt->get_result();  // Obtenemos el resultado de la consulta

        // Si el usuario existe y la contraseña es correcta, devolvemos los datos del usuario
        $usuario = $resultado->fetch_assoc();  // Obtenemos los datos del usuario en un array asociativo
        if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
            return $usuario;  // Si la contraseña es correcta, devolvemos los datos del usuario
        }
        return false;  // Si no existe el usuario o la contraseña es incorrecta, devolvemos false
    }
}
?>