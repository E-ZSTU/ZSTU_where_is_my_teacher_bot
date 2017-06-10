<?php
declare(strict_types = 1);

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Request;

/**
 * Class DepartmentForeignLanguagesCommand
 * @package Longman\TelegramBot\Commands\SystemCommands
 */
class ForeignLanguagesCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'foreign_languages';
    
    /**
     * @var string
     */
    protected $description = 'Викладачи кафедри іноземних мов';
    
    /**
     * @var string
     */
    protected $usage = '/foreign_languages';
    
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
            ['Давидович М.С.',],
            ['Канчура Є.О.'],
            ['Кобзар С.К.'],
            ['Ковальчук І.С.'],
            ['Колодій О.А.'],
            ['Крушинська Н.І.'],
            ['Кур\'ята С.Г.'],
            ['Курносова Н.О.'],
            ['Мельниченко І.С.'],
            ['Могельницька Л.Ф.'],
            ['Сивак О.Б.'],
            ['Суховецька С.В.'],
            ['Фурсова Л.І.'],
            ['Шадура В.А.']
        );
        //Return a random keyboard.
        $keyboard->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->setSelective(false);
        $chat_id = $this->getMessage()->getChat()->getId();
        $data = [
            'chat_id' => $chat_id,
            'text' => 'Виберіть викладача кафедри',
            'reply_markup' => $keyboard,
        ];
        
        return Request::sendMessage($data);
    }
}