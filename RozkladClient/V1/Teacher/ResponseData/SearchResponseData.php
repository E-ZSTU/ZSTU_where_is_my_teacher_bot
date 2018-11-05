<?php
declare(strict_types = 1);

namespace ZSTU\RozkladClient\V1\Teacher\ResponseData;

/**
 * Class SearchResponseData
 *
 * @package ZSTU\RozkladClient\V1\Teacher\ResponseData
 */
class SearchResponseData
{
    /**
     * @var TeacherData|null
     */
    private $searched;

    /**
     * @var $this |\Illuminate\Support\Collection|TeacherData[]
     */
    private $suggest;

    /**
     * SearchResponseData constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->searched = empty($data['searched']) ? null : new TeacherData($data['searched']);
        $this->suggest = TeacherCollection::make($data['suggest']);
    }

    /**
     * @return null|TeacherData
     */
    public function getSearched(): ?TeacherData
    {
        return $this->searched;
    }

    /**
     * @return TeacherCollection
     */
    public function getSuggest(): TeacherCollection
    {
        return $this->suggest;
    }
}
