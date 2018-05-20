<?php
declare(strict_types = 1);

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Request;

/**
 * User "/help" command
 */
class HelpCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'help';
    
    /**
     * @var string
     */
    protected $description = 'Show bot commands help';
    
    /**
     * @var string
     */
    protected $usage = '/help or /help <command>';
    
    /**
     * @var string
     */
    protected $version = '0.0.1';
    
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
        
        $text = 'Надрукуйте фамілію викладача, або частину фамілії і я допоможу вам віднайти його'
            . PHP_EOL . 'Наприклад: Морозов';
        
        $data = [
            'chat_id' => $chat_id,
            'text' => $text,
        ];
        
        return Request::sendMessage($data);
    }
}