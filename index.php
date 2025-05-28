<?php
// Forzar salida como JSON
header('Content-Type: application/json');

// Capturar entrada cruda
$raw_input = file_get_contents('php://input');

// Intentar decodificar JSON
$input = json_decode($raw_input, true);

// Guardar todo el JSON recibido en log.txt (para depuración)
file_put_contents("log.txt", json_encode([
    'timestamp' => date('Y-m-d H:i:s'),
    'input_raw' => $raw_input,
    'input_decoded' => $input
], JSON_PRETTY_PRINT) . PHP_EOL, FILE_APPEND);

// Si el JSON no se decodificó correctamente, registrar error
if (json_last_error() !== JSON_ERROR_NONE) {
    file_put_contents("error_log.txt", date('Y-m-d H:i:s') . " ❌ Error al decodificar JSON: " . json_last_error_msg() . PHP_EOL, FILE_APPEND);
    echo json_encode(['content' => 'Error: JSON inválido.']);
    exit;
}

// Validar que haya evento de tipo "message_created"
if (isset($input['event']) && $input['event'] === 'message_created') {
    // Opcional: puedes validar también que no venga de un bot (para evitar loops)
    $from_bot = $input['message']['sender']['type'] ?? '';
    if ($from_bot === 'bot') {
        echo json_encode(['content' => 'Ignorado: mensaje de bot.']);
        exit;
    }

    // Ejemplo de respuesta
    echo json_encode([
        'content' => 'Hola, soy el asistente automático. ¿En qué puedo ayudarte?'
    ]);
    exit;
}

// Si no es un evento relevante, responder neutro
echo json_encode(['content' => 'Evento recibido, sin acción.']);
exit;
// Mostrar también en consola
error_log("🟡 Entrada cruda: " . $raw_input);
error_log("✅ JSON decodificado: " . json_encode($input, JSON_PRETTY_PRINT));

if (json_last_error() !== JSON_ERROR_NONE) {
    error_log("❌ Error de JSON: " . json_last_error_msg());
}
