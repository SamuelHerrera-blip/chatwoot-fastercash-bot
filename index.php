<?php
header('Content-Type: application/json');

// Recibir el JSON
$input = json_decode(file_get_contents('php://input'), true);

// Guardar log en archivo local
file_put_contents("log.txt", json_encode($input, JSON_PRETTY_PRINT) . PHP_EOL, FILE_APPEND);

// Ver respuesta en pantalla
echo json_encode([
    'content' => "DEBUG:\n" . json_encode($input, JSON_PRETTY_PRINT)
]);
exit;
