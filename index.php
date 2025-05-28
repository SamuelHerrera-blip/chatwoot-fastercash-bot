<?php
header('Content-Type: application/json');

// Recibir JSON
$input = json_decode(file_get_contents('php://input'), true);

// Extraer mensaje del usuario
$msg = strtolower(trim($input['content'] ?? ''));

// Generar respuesta
switch ($msg) {
    case '1':
        $reply = "Consulta tu cuenta aquí: https://fastercash.mx";
        break;
    case '2':
        $reply = "Tiempo promedio de aprobación: 2 horas.";
        break;
    default:
        $reply = "Hola 👋, responde con:\n1️⃣ Ya soy cliente\n2️⃣ Todavía no soy cliente";
        break;
}

// Responder a Chatwoot
echo json_encode([
    'content' => $reply
]);
