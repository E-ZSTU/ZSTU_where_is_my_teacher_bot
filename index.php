<?php

require_once __DIR__ . '/vendor/autoload.php';

use Longman\TelegramBot\Exception\TelegramException;
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
    
    return [
        'statusCode' => 200,
        'body' => $telegram->getLastCommandResponse()->__toString(),
    ];
} catch (TelegramException $e) {
    
    return [
        'statusCode' => 500,
        'body' => $e->getMessage(),
    ];
}
