<?php
// ✅ VERSIÓN SEGURA: Consulta preparada con PDO (anti SQL injection)
require_once '../config/conexion.php';

header('Content-Type: application/json; charset=utf-8');

// Tomamos el término de búsqueda (si no viene, queda vacío)
$q = $_GET['q'] ?? '';

try {
    // 1) FASE DE PREPARACIÓN: la consulta viaja con un marcador (:termino),
    //    sin ningún dato del usuario. La estructura queda fijada acá.
    $sql  = "SELECT id, nombre, categoria, precio, stock
             FROM productos
             WHERE nombre LIKE :termino
             ORDER BY nombre ASC";
    $stmt = $pdo->prepare($sql);

    // 2) FASE DE EJECUCIÓN: recién ahora mandamos el dato, por separado.
    //    Los comodines % se agregan al VALOR, no a la sentencia SQL.
    $stmt->execute([':termino' => '%' . $q . '%']);

    $productos = $stmt->fetchAll();

    http_response_code(200);
    echo json_encode([
        "estado" => "exito",
        "total"  => count($productos),
        "data"   => $productos
    ], JSON_UNESCAPED_UNICODE);

} catch (\PDOException $e) {
    // Si algo falla, no mostramos detalles del motor al usuario
    http_response_code(500);
    echo json_encode([
        "estado"  => "error",
        "mensaje" => "Ocurrió un error al realizar la búsqueda."
    ], JSON_UNESCAPED_UNICODE);
}
