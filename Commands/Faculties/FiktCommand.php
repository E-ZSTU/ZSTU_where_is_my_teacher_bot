<?php
declare(strict_types = 1);

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Request;

/**
 * Class FacultyCommand
 * @package Longman\TelegramBot\Commands\SystemCommands
 */
class FiktCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'fikt';
    
    /**
     * @var string
     */
    protected $description = 'Пошук викладачів за факультетом';
    
    /**
     * @var string
     */
    protected $usage = '/fikt';
    
    /**
     * @var string
     */
    protected $version = '0.0.1';
    
    /**
     * @var bool
     */
    protected $show_in_help = false;

    /**
     * Command execute method
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute()
    {
        $keyboard = new Keyboard(
            ['Кафедра інженерії програмного забезпечення',],
            ['ФІКТ', 'ФІМ', 'ФОФ',]
        );
        //Return a random keyboard.
        $keyboard->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->setSelective(false);
        $chat_id = $this->getMessage()->getChat()->getId();
        $data = [
            'chat_id' => $chat_id,
            'text' => 'Виберіть факультет кафедри викладача:',
            'reply_markup' => $keyboard,
        ];
        
        return Request::sendMessage($data);
    }
}