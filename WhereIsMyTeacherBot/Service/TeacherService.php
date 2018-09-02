<?php
declare(strict_types = 1);

namespace WhereIsMyTeacherBot\Service;

use Carbon\Carbon;
use Symfony\Component\Cache\Simple\FilesystemCache;
use WhereIsMyTeacherBot\Model\TeacherParser;

/**
 * Class TeacherService
 *
 * @package WhereIsMyTeacherBot\Service
 */
class TeacherService
{
    /**
     * @var FilesystemCache
     */
    private $cache;

    /**
     * TeacherService constructor.
     */
    public function __construct()
    {
        $this->cache = new FilesystemCache('teacher-schedule-unique-1',
            Carbon::SECONDS_PER_MINUTE * Carbon::MINUTES_PER_HOUR * Carbon::HOURS_PER_DAY * Carbon::DAYS_PER_WEEK
        );
    }

    /**
     * @param string $teacherName
     *
     * @return mixed|null|string
     */
    public function getSchedule(string $teacherName)
    {
        $week = Carbon::now()->weekOfYear % 2;
        $cacheKey = md5($teacherName . $week);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $teacherParser = new TeacherParser($teacherName);
        $answer = $teacherParser->parse();

        $this->cache->set($cacheKey, $answer);

        return $answer;
    }
}
