<?php
// Configuración de la base de datos
$host = 'localhost';
$dbname = 'gestion_tareas';
$username = 'root';
$password = 'curso';

try {
    // Intentamos crear una conexión a la base de datos utilizando PDO (PHP Data Objects).
    // La cadena de conexión indica el tipo de base de datos (mysql), el host (localhost) y el nombre de la base de datos.
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Configurar el manejo de errores para que PDO lance excepciones si ocurre un error.
    // Esto es útil para identificar problemas rápidamente durante el desarrollo.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Establecemos que la codificación de caracteres será UTF-8. Esto es importante para manejar caracteres especiales y acentos correctamente.
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    // Si ocurre un error en la conexión, atrapamos la excepción y mostramos un mensaje de error con el detalle.
    // La función die() termina la ejecución del script.
    die("Error de conexión: " . $e->getMessage());
}
?>