<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'error_log.txt');
error_reporting(E_ALL);
header('Content-Type: application/json');


// Recibir entrada bruta
$raw_input = file_get_contents('php://input');
file_put_contents('log.txt', "🟡 Entrada cruda: $raw_input\n", FILE_APPEND);

// Decodificar JSON
$input = json_decode($raw_input, true);
file_put_contents('log.txt', "✅ JSON decodificado: " . json_encode($input, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);

// Validar que el JSON y los campos existan
if (!is_array($input) || !isset($input['event']) || $input['event'] !== 'message_created') {
    file_put_contents('log.txt', "⚠️ Faltan campos esperados en el payload.\n", FILE_APPEND);
    http_response_code(400);
    echo json_encode(['error' => 'Payload inválido o sin evento válido.']);
    exit;
}

// Extraer datos
$message = $input['content'] ?? '';
$phone   = $input['sender']['phone_number'] ?? '';
$name    = $input['sender']['name'] ?? '';
$inbox   = $input['inbox']['id'] ?? null;

// Validar campos clave
if (!$message || !$phone || !$inbox) {
    file_put_contents('log.txt', "❌ Campos esenciales ausentes (mensaje, teléfono o inbox).\n", FILE_APPEND);
    http_response_code(422);
    echo json_encode(['error' => 'Faltan campos esenciales.']);
    exit;
}

file_put_contents('log.txt', "📨 Mensaje recibido: $message de $phone ($name)\n", FILE_APPEND);

// Construir respuesta automática
$response_text = "¡Hola $name! 👋 Gracias por escribirnos. Soy el asistente de Faster Cash y te apoyaré en lo que pueda.";

// Preparar respuesta
$response = [
    'content' => $response_text,
];

// Responder
file_put_contents('log.txt', "✅ Respondido con: $response_text\n", FILE_APPEND);
echo json_encode($response);
exit;
