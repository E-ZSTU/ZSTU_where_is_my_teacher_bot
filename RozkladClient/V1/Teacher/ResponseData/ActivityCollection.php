<?php
declare(strict_types = 1);

namespace ZSTU\RozkladClient\V1\Teacher\ResponseData;

use Illuminate\Support\Collection;

/**
 * Class ActivityCollection
 *
 * @method ActivityData[] all()
 *
 * @package ZSTU\RozkladClient\V1\Teacher\ResponseData
 */
class ActivityCollection extends Collection
{
    /**
     * @param array $items
     *
     * @return $this|Collection|ActivityData[]
     */
    public static function make($items = [])
    {
        if (\is_array($items)) {
            $items = array_map(function ($item) {
                return new ActivityData($item);
            }, $items);
        }

        return parent::make($items);
    }
}
