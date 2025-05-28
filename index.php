<?php
header('Content-Type: application/json');

// Recibir el JSON
$input = json_decode(file_get_contents('php://input'), true);

// Guardar log en archivo local (opcional)
file_put_contents("log.txt", json_encode($input, JSON_PRETTY_PRINT) . PHP_EOL, FILE_APPEND);

// Mostrar contenido recibido como respuesta
echo json_encode([
    'content' => "📦 DEBUG:\n" . json_encode($input, JSON_PRETTY_PRINT)
]);
exit;
