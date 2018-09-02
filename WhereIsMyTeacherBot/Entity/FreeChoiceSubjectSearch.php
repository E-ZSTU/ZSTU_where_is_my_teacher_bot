<?php
declare(strict_types = 1);

namespace WhereIsMyTeacherBot\Entity;

/**
 * Class FreeChoiceSubjectSearch
 *
 * @package WhereIsMyTeacherBot\Entity
 */
class FreeChoiceSubjectSearch
{
    /**
     * @var string
     */
    private $week;

    /**
     * @var string
     */
    private $teacher;

    /**
     * @var string
     */
    private $startAt;

    /**
     * @var string
     */
    private $day;

    /**
     * FreeChoiceSubjectSearch constructor.
     *
     * @param string $week
     * @param string $teacher
     * @param string $startAt
     * @param string $day
     */
    public function __construct(string $week, string $teacher, string $startAt, string $day)
    {
        $this->week = $week;
        $this->teacher = $teacher;
        $this->startAt = $startAt;
        $this->day = $day;
    }

    /**
     * @return string
     */
    public function getWeek(): string
    {
        return $this->week;
    }

    /**
     * @return string
     */
    public function getTeacher(): string
    {
        return $this->teacher;
    }

    /**
     * @return string
     */
    public function getStartAt(): string
    {
        if (mb_strlen($this->startAt) === 4) {
            return '0' . $this->startAt;
        }

        return $this->startAt;
    }

    /**
     * @return string
     */
    public function getDay(): string
    {
        return $this->day;
    }
}
