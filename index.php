<?php

require_once __DIR__ . '/vendor/autoload.php';

use Longman\TelegramBot\Telegram;

try {
    // Create Telegram API object
    $telegram = new Telegram(
        'api_key',
        'bot_name'
    );
    $telegram->addCommandsPath(__DIR__ . '/Commands');

    // Handle telegram webhook request
    $telegram->handle();
} catch (Exception $e) {
    echo "<pre>$e</pre>";
}
