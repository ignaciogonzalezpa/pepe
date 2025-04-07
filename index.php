<?php
$token = '8024202425:AAHZU-uiizGkjfUweisefXFMx4QSd7G-ENs';
$api_url = "https://api.telegram.org/bot$token/";

// Diccionario de pasillos
$pasillos = [
    "pasillo 1" => ["Carne", "Queso", "Jamón"],
    "pasillo 2" => ["Leche", "Yogurth", "Cereal"],
    "pasillo 3" => ["Bebidas", "Jugos"],
    "pasillo 4" => ["Pan", "Pasteles", "Tortas"],
    "pasillo 5" => ["Detergente", "Lavaloza"]
];

// Obtener el cuerpo de la solicitud que contiene la actualización de Telegram
$update = json_decode(file_get_contents('php://input'), true);

if (isset($update['message'])) {
    $message = $update['message'];
    $chat_id = $message['chat']['id'];
    $text = strtolower(trim($message['text'] ?? ""));

    $respuesta = "Lo siento, no encontré ese pasillo.";

    foreach ($pasillos as $pasillo => $productos) {
        if (strpos($text, strtolower($pasillo)) !== false) {
            $respuesta = "En $pasillo puedes encontrar: " . implode(", ", $productos);
            break;
        }
    }

    if ($text == "hola") {
        $respuesta = "¡Hola! ¿En qué te puedo ayudar?";
    }

    // Enviar la respuesta a Telegram
    $url = $api_url . "sendMessage?chat_id=$chat_id&text=" . urlencode($respuesta);
    file_get_contents($url);
}
?>
