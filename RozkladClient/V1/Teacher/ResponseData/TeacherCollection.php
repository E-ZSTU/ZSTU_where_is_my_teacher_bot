<?php
declare(strict_types = 1);

namespace ZSTU\RozkladClient\V1\Teacher\ResponseData;

use Illuminate\Support\Collection;

/**
 * Class TeacherCollection
 *
 * @method TeacherData[] all()
 *
 * @package ZSTU\RozkladClient\V1\Teacher\ResponseData
 */
class TeacherCollection extends Collection
{
    /**
     * @param array $items
     *
     * @return $this|Collection|TeacherData[]
     */
    public static function make($items = [])
    {
        if (\is_array($items)) {
            $items = array_map(function ($item) {
                return new TeacherData($item);
            }, $items);
        }

        return parent::make($items);
    }
}
