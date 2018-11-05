<?php
declare(strict_types = 1);

namespace ZSTU\RozkladClient\V1\Teacher\ResponseData;

/**
 * Class ScheduleResponseData
 *
 * @package ZSTU\RozkladClient\V1\Teacher\ResponseData
 */
class ScheduleResponseData
{
    /**
     * @var int
     */
    private $teacherId;

    /**
     * @var \Illuminate\Support\Collection|ActivityData[]
     */
    private $activities;

    /**
     * @var string
     */
    private $teacherName;

    /**
     * ScheduleResponseData constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->teacherName = (string) $data['teacher_name'];
        $this->teacherId = (int) $data['teacher_id'];
        $this->activities = ActivityCollection::make($data['activities']);
    }

    /**
     * @return int
     */
    public function getTeacherId(): int
    {
        return $this->teacherId;
    }

    /**
     * @return ActivityCollection
     */
    public function getActivities(): ActivityCollection
    {
        return $this->activities;
    }

    /**
     * @return string
     */
    public function getTeacherName(): string
    {
        return $this->teacherName;
    }
}
