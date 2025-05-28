<?php
// Establece cabecera de respuesta
header('Content-Type: application/json');

// Captura la entrada cruda
$raw_input = file_get_contents('php://input');
error_log("🟡 Entrada cruda: " . $raw_input);

// Intenta decodificar
$input = json_decode($raw_input, true);
error_log("✅ JSON decodificado: " . json_encode($input, JSON_PRETTY_PRINT));

// Valida si hubo error
if (json_last_error() !== JSON_ERROR_NONE) {
    error_log("❌ Error de JSON: " . json_last_error_msg());
    http_response_code(400);
    echo json_encode(['error' => 'JSON inválido']);
    exit;
}

// Verifica si es un evento válido (mensaje entrante)
if (!isset($input['content']) || !isset($input['conversation']['meta']['sender']['phone_number'])) {
    error_log("⚠️ Faltan campos esperados en el payload.");
    http_response_code(422);
    echo json_encode(['error' => 'Faltan campos']);
    exit;
}

// Simula una respuesta del bot
$response = [
    'content' => "Hola, soy el bot de Faster Cash 🤖. En breve te atenderemos."
];

// Devuelve respuesta simulada
echo json_encode($response, JSON_PRETTY_PRINT);
exit;
