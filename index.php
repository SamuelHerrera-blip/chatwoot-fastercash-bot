<?php
header('Content-Type: application/json');

// Recibir el JSON
$input = json_decode(file_get_contents('php://input'), true);

// Guardar log en archivo local
file_put_contents("log.txt", json_encode($input, JSON_PRETTY_PRINT) . PHP_EOL, FILE_APPEND);

// Procesar el mensaje
$msg = strtolower(trim($input['content'] ?? ''));

switch ($msg) {
    case '1':
        $reply = "Consulta tu cuenta aquí: https://fastercash.mx";
        break;
    case '2':
        $reply = "Pronto estaremos contigo.";
        break;
    default:
        $reply = "Escribe 1 para ver tu cuenta o 2 para esperar a un asesor.";
}

// Devolver respuesta al Webhook
echo json_encode([
    'content' => $reply
]);
exit;

// Responder a Chatwoot
echo json_encode([
    'content' => $reply
]);
