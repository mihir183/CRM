<?php
require 'secret.php';

require __DIR__ . '/vendor/autoload.php';

use Twilio\Rest\Client;

// Your Twilio Account SID & Auth Token
$sid = $SID;
$token = $TTOKEN;
$client = new Client($sid, $token);

// WhatsApp numbers
$twilio_whatsapp = "whatsapp:+14155238886";  // Twilio sandbox number
$user_number = "whatsapp:+91XXXXXXXXXX";     // Your phone (must join sandbox)

$message = $client->messages->create(
    $user_number,
    [
        "from" => $twilio_whatsapp,
        "body" => "Hello from PHP via Twilio WhatsApp API!"
    ]
);

echo "Message sent! SID: " . $message->sid;
