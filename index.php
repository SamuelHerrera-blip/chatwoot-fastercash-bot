<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

// Guardar log para debug
file_put_contents("log.txt", json_encode($input) . PHP_EOL, FILE_APPEND);

// Obtener mensaje del usuario
$msg = strtolower(trim($input['content'] ?? ''));

// Lógica básica de respuesta
switch ($msg) {
    case '1':
        $reply = "Consulta tu cuenta aquí: https://fastercash.mx";
        break;
    case '2':
        $reply = "Puedes renovar tu beneficio después de liquidar el anterior.";
        break;
    default:
        $reply = "Responde con:\n1. Ya soy cliente\n2. Renovar beneficio";
        break;
}

// Enviar respuesta en formato que espera Chatwoot
echo json_encode([
    "content" => $reply,
]);
exit;

