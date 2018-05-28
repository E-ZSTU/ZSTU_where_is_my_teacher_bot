<?php

require_once __DIR__ . '/vendor/autoload.php';
require 'bootstrap.php';

use Longman\TelegramBot\Telegram;

try {
    Longman\TelegramBot\TelegramLog::initErrorLog('var/log/bot.log');
    // Create Telegram API object
    $telegram = new Telegram(
        'api_key',
        'bot_name'
    );
    $telegram->addCommandsPath(__DIR__ . '/Commands');

    // Handle telegram webhook request
    $telegram->handle();
} catch (\Longman\TelegramBot\Exception\TelegramException $e) {
    \Longman\TelegramBot\TelegramLog::error($e);
}