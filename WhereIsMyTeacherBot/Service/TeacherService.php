<?php
declare(strict_types = 1);

namespace WhereIsMyTeacherBot\Service;

use Symfony\Component\Cache\Simple\FilesystemCache;
use WhereIsMyTeacherBot\Model\TeacherParser;

class TeacherService
{
    const SCHEDULE = 'https://rozklad.ztu.edu.ua/schedule/teacher/';

    /**
     * @var FilesystemCache
     */
    private $cache;

    /**
     * TeacherService constructor.
     */
    public function __construct()
    {
        $this->cache = new FilesystemCache();
    }

    /**
     * @param string $teacherName
     *
     * @return mixed|null|string
     */
    public function getSchedule(string $teacherName)
    {
        $cacheKey = md5($teacherName);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $teacherUrl = self::SCHEDULE . $teacherName;

        $answer = TeacherParser::parse($teacherUrl, $teacherName)
            . PHP_EOL . "<a href='$teacherUrl'>Повний розклад викладача</a>";

        $this->cache->set($cacheKey, $answer);

        return $answer;
    }
}
