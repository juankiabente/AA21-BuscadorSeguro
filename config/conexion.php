<?php
// Configuración de credenciales del servidor MySQL
$host    = 'localhost';
$db      = 'clase_backend';
$user    = 'root';
$pass    = '';            // XAMPP: root no tiene contraseña por defecto
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Opciones del driver PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lanza PDOException ante errores
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Devuelve arreglos asociativos
    PDO::ATTR_EMULATE_PREPARES   => false,                 // Prepared statements reales (no emulados)
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión con la base de datos: " . $e->getMessage()]);
    exit;
}
