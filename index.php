<?php
// Mostrar errores durante desarrollo
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'error_log.txt');

// Encabezado para respuesta JSON
header('Content-Type: application/json');

// 🔍 Confirmar que se recibió el webhook
file_put_contents('log.txt', "📥 Webhook recibido: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

// 1. Leer entrada bruta
$raw_input = file_get_contents('php://input');
file_put_contents('log.txt', "🟡 Entrada cruda: $raw_input\n", FILE_APPEND);

// 2. Intentar decodificar JSON
$input = json_decode($raw_input, true);
file_put_contents('log.txt', "✅ JSON decodificado: " . json_encode($input, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);

// 3. Validar estructura mínima
if (!is_array($input) || !isset($input['event'])) {
    file_put_contents('log.txt', "⚠️ No se encontró el campo 'event'.\n", FILE_APPEND);
    http_response_code(400);
    echo json_encode(['error' => 'Falta campo "event".']);
    exit;
}

if ($input['event'] !== 'message_created') {
    file_put_contents('log.txt', "⛔ Evento no válido: {$input['event']} (esperado: 'message_created')\n", FILE_APPEND);
    http_response_code(200); // responder 200 para evitar reintentos
    echo json_encode(['message' => 'Evento no procesado.']);
    exit;
}

// 4. Extraer datos necesarios
$message = $input['content'] ?? '';
$phone   = $input['sender']['phone_number'] ?? '';
$name    = $input['sender']['name'] ?? '';
$inbox   = $input['inbox']['id'] ?? null;

// 5. Validar campos clave
if (!$message || !$phone || !$inbox) {
    file_put_contents('log.txt', "❌ Campos esenciales ausentes: mensaje='$message', teléfono='$phone', inbox='$inbox'.\n", FILE_APPEND);
    http_response_code(422);
    echo json_encode(['error' => 'Faltan campos esenciales.']);
    exit;
}

// 6. Registrar mensaje recibido
file_put_contents('log.txt', "📨 Mensaje recibido: '$message' de $phone ($name)\n", FILE_APPEND);

// 7. Generar respuesta automática
$response_text = "¡Hola $name! 👋 Gracias por escribirnos. Soy el asistente de Faster Cash y te apoyaré en lo que pueda.";

// 8. Registrar respuesta
file_put_contents('log.txt', "✅ Respondido con: $response_text\n", FILE_APPEND);

// 9. Devolver respuesta
echo json_encode([
    'content' => $response_text
]);
exit;
