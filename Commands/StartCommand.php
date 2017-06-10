<?php
declare(strict_types = 1);

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Request;

/**
 * Start command
 *
 * Gets executed when a user first starts using the bot.
 */
class StartCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'start';
    
    /**
     * @var string
     */
    protected $description = 'Start command';
    
    /**
     * @var string
     */
    protected $usage = '/start';
    
    /**
     * @var string
     */
    protected $version = '1.1.0';
    
    /**
     * @var bool
     */
    protected $private_only = true;
    
    /**
     * Command execute method
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute()
    {
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();
        
        $text = 'Привіт!' . PHP_EOL .
            'Даний бот допоможе тобі віднайти розклад викладача!' . PHP_EOL .
            'Натисни /help для перегляду всіх команд';
        
        $data = [
            'chat_id' => $chat_id,
            'text' => $text,
        ];
        
        return Request::sendMessage($data);
    }
}
