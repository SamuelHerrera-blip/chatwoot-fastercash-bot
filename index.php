<?php
header('Content-Type: application/json');

// Capturar entrada cruda
$raw_input = file_get_contents('php://input');
error_log("🟡 Entrada cruda: " . $raw_input);

// Decodificar JSON
$input = json_decode($raw_input, true);
error_log("✅ JSON decodificado: " . json_encode($input, JSON_PRETTY_PRINT));

// Verificar error en JSON
if (json_last_error() !== JSON_ERROR_NONE) {
    error_log("❌ Error de JSON: " . json_last_error_msg());
    http_response_code(400);
    echo json_encode(['error' => 'JSON inválido']);
    exit;
}

// Validar campos necesarios
if (!isset($input['content']) || !isset($input['conversation']['meta']['sender']['phone_number'])) {
    error_log("⚠️ Faltan campos esperados en el payload.");
    http_response_code(422);
    echo json_encode(['error' => 'Faltan campos']);
    exit;
}

// Leer contenido del mensaje
$mensaje = strtolower(trim($input['content']));
error_log("📨 Mensaje recibido: " . $mensaje);

// Lógica básica del bot
if (strpos($mensaje, 'cliente') !== false) {
    $respuesta = "Entendido. En breve te apoyaremos como cliente actual. 🧾";
} elseif (strpos($mensaje, 'nuevo') !== false || strpos($mensaje, 'quiero') !== false) {
    $respuesta = "Gracias por tu interés. Por favor llena la solicitud en fastercash.app 🚀";
} else {
    $respuesta = "Hola, soy el bot de Faster Cash 🤖. ¿Ya eres cliente? Escribe: 'Soy cliente' o 'No soy cliente'.";
}

// Enviar respuesta a Chatwoot
echo json_encode([
    'content' => $respuesta
], JSON_PRETTY_PRINT);
exit;
