<?php
declare(strict_types = 1);

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use WhereIsMyTeacherBot\TelegramView\RoomScheduleView;
use ZSTU\RozkladClient\Client;

/**
 * Class RoomCommand
 *
 * @package Longman\TelegramBot\Commands\SystemCommands
 */
class RoomCommand extends UserCommand
{
    /**
     * @var Client
     */
    protected $rozkladClient;

    /**
     * @var RoomScheduleView
     */
    protected $roomScheduleView;

    /**
     * @var string
     */
    protected $name = 'room';

    /**
     * @var string
     */
    protected $description = 'Пошук аудиторії';

    /**
     * @var string
     */
    protected $usage = '/room';

    /**
     * @var string
     */
    protected $version = '0.0.1';

    /**
     * RoomCommand constructor.
     *
     * @param Telegram    $telegram
     * @param Update|null $update
     */
    public function __construct(Telegram $telegram, Update $update = null)
    {
        parent::__construct($telegram, $update);
        $this->rozkladClient = new Client();
        $this->roomScheduleView = new RoomScheduleView();
    }

    /**
     * Execute command
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute()
    {
        $message = $this->getMessage();

        $room = $message->getText(true);

        $searchResult = $this->rozkladClient->v1()->room()->search($room);

        if ($searchResult->getSearched()) {

            $schedule = $this->rozkladClient->v1()->room()->schedule($searchResult->getSearched()->getId());

            return Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'text' => $this->roomScheduleView->toHtml($schedule),
                'parse_mode' => 'HTML',
            ]);
        }

        if ($searchResult->getSuggest()->isNotEmpty()) {
            $patterns = [];

            foreach ($searchResult->getSuggest()->all() as $roomData){
                $patterns[] = ['/room ' . $roomData->getRoomName()];
            }
            $keyboard = new Keyboard(...$patterns);

            $keyboard->setResizeKeyboard(true)
                ->setOneTimeKeyboard(true)
                ->setSelective(false);

            $data = [
                'chat_id' => $message->getChat()->getId(),
                'text' => 'Виберіть аудиторію, яку шукаєте',
                'reply_markup' => $keyboard,
            ];

            return Request::sendMessage($data);
        }

        $data = [
            'chat_id' => $message->getChat()->getId(),
            'text' => 'Вибачне, я не можу віднайти дану аудиторію. /help допоможе вам',
            'parse_mode' => 'Markdown',
        ];

        return Request::sendMessage($data);
    }
}
