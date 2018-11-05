<?php
declare(strict_types = 1);

namespace ZSTU\RozkladClient\V1\Teacher\ResponseData;

/**
 * Class TeacherData
 *
 * @package ZSTU\RozkladClient\V1\Teacher\ResponseData
 */
class TeacherData
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $teacher_name;

    /**
     * TeacherData constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->id = (int) $data['id'];
        $this->teacher_name = (string) $data['teacher_name'];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTeacherName(): string
    {
        return $this->teacher_name;
    }
}
