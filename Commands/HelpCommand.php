<?php
declare(strict_types = 1);

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\Command;
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
        $command = trim($message->getText(true));
        //Only get enabled Admin and User commands
        /** @var Command[] $command_objs */
        $command_objs = array_filter($this->telegram->getCommandsList(), function ($command_obj) {
            /** @var Command $command_obj */
            return !$command_obj->isSystemCommand() && $command_obj->isEnabled();
        });
        //If no command parameter is passed, show the list
        if ($command === '') {
            $text = 'Надрукуйте фамілію викладача, або частину фамілії і я допоможу вам віднайти його'
                . PHP_EOL . 'Наприклад: Морозов';
        } else {
            $command = str_replace('/', '', $command);
            if (isset($command_objs[$command])) {
                /** @var Command $command_obj */
                $command_obj = $command_objs[$command];
                $text = sprintf(
                    'Command: %s v%s' . PHP_EOL .
                    'Description: %s' . PHP_EOL .
                    'Usage: %s',
                    $command_obj->getName(),
                    $command_obj->getVersion(),
                    $command_obj->getDescription(),
                    $command_obj->getUsage()
                );
            } else {
                $text = 'No help available: Command /' . $command . ' not found';
            }
        }
        $data = [
            'chat_id' => $chat_id,
            'text' => $text,
        ];
        
        return Request::sendMessage($data);
    }
}