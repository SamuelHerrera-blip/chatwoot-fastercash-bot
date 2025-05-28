<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

// Guardar log (opcional)
file_put_contents("log.txt", json_encode($input) . PHP_EOL, FILE_APPEND);

$msg = strtolower(trim($input['content'] ?? ''));

switch ($msg) {
    case '1':
    case 'ya soy cliente':
        $reply = "Consulta tu cuenta aquí: https://fastercash.mx";
        break;
    case '2':
    case 'todavia no soy cliente':
        $reply = "Puedes solicitar tu beneficio en: https://fastercash.mx";
        break;
    default:
        $reply = "👋 Hola, soy tu asistente automático.  
1️⃣ Ya soy cliente  
2️⃣ Todavía no soy cliente  
Escribe el número de la opción.";
        break;
}

echo json_encode([
    'content' => $reply
]);

echo json_encode([
    'content' => $reply
]);
