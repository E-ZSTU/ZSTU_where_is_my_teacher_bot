<?php
declare(strict_types = 1);

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\Message;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use WhereIsMyTeacherBot\Dictionary\TeacherDictionary;
use WhereIsMyTeacherBot\Service\TeacherService;

/**
 * Class GenericmessageCommand
 * @package Longman\TelegramBot\Commands\SystemCommands
 */
class GenericmessageCommand extends SystemCommand
{
    /**
     * @var TeacherService
     */
    protected $teacherService;

    /**
     * @var string
     */
    protected $name = 'Generic';

    /**
     * @var string
     */
    protected $version = '0.0.1';

    /**
     * GenericmessageCommand constructor.
     *
     * @param Telegram    $telegram
     * @param Update|null $update
     */
    public function __construct(Telegram $telegram, Update $update = null)
    {
        parent::__construct($telegram, $update);
        $this->teacherService = new TeacherService();
    }

    /**
     * Command execute method
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute()
    {
        $message = $this->getMessage();
        $answer = 'Вибачте, я не розумію вас. Команда /help допоможе вам';

        $teachers = TeacherDictionary::getTeachers();

        if (\in_array($message->getText(), $teachers, true)) {
            $answer = $this->teacherService->getSchedule($message->getText());

            return Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'text' => $answer,
                'parse_mode' => 'HTML',
            ]);
        }

        if (($data = $this->searchTextOccurrences($teachers, $message)) !== null) {

            return Request::sendMessage($data);
        }

        $data = [
            'chat_id' => $message->getChat()->getId(),
            'text' => $answer,
            'parse_mode' => 'Markdown',
        ];

        return Request::sendMessage($data);
    }

    /**
     * @param array   $teachers
     * @param Message $message
     *
     * @return array|null
     */
    private function searchTextOccurrences(array $teachers, Message $message): ?array
    {
        $patterns = [];
        foreach ($teachers as $teacher) {
            if (mb_stripos($teacher, $message->getText()) !== false) {
                $patterns[] = [$teacher];
            }
        }
        if (!empty($patterns)) {
            $keyboard = new Keyboard(...$patterns);

            $keyboard->setResizeKeyboard(true)
                ->setOneTimeKeyboard(true)
                ->setSelective(false);

            $data = [
                'chat_id' => $message->getChat()->getId(),
                'text' => 'Виберіть викладача якого ви шукаєте',
                'reply_markup' => $keyboard,
            ];

            return $data;
        }

        return null;
    }
}