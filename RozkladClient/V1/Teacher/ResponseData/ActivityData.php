<?php
declare(strict_types = 1);

namespace ZSTU\RozkladClient\V1\Teacher\ResponseData;

/**
 * Class ActivityData
 *
 * @package ZSTU\RozkladClient\V1\Teacher\ResponseData
 */
class ActivityData
{
    /**
     * @var string
     */
    private $tag;

    /**
     * @var string
     */
    private $day;

    /**
     * @var string
     */
    private $room;

    /**
     * @var int
     */
    private $hourId;

    /**
     * @var string
     */
    private $groups;

    /**
     * @var string
     */
    private $hourName;

    /**
     * @var string
     */
    private $teacherName;

    /**
     * @var string
     */
    private $subjectName;

    /**
     * ActivityData constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->day = (string) $data['day'];
        $this->tag = (string) $data['tag'];
        $this->room = (string) $data['room'];
        $this->hourId = (int) $data['hour_id'];
        $this->groups = (string) $data['groups'];
        $this->hourName = (string) $data['hour_name'];
        $this->teacherName = (string) $data['teacher_name'];
        $this->subjectName = (string) $data['subject_name'];
    }

    /**
     * @return string
     */
    public function getHourName(): string
    {
        return $this->hourName;
    }

    /**
     * @return string
     */
    public function getGroups(): string
    {
        return $this->groups;
    }

    /**
     * @return string
     */
    public function getRoom(): string
    {
        return $this->room;
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @return int
     */
    public function getHourId(): int
    {
        return $this->hourId;
    }

    /**
     * @return string
     */
    public function getDay(): string
    {
        return $this->day;
    }

    /**
     * @return string
     */
    public function getTeacherName(): string
    {
        return $this->teacherName;
    }

    /**
     * @return string
     */
    public function getSubjectName(): string
    {
        return $this->subjectName;
    }
}
