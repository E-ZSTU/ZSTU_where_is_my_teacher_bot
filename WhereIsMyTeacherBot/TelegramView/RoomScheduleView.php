<?php
declare(strict_types = 1);

namespace WhereIsMyTeacherBot\TelegramView;

use ZSTU\RozkladClient\V1\ResponseData\Activity\ActivityCollection;
use ZSTU\RozkladClient\V1\ResponseData\Activity\ActivityData;
use ZSTU\RozkladClient\V1\ResponseData\Room\RoomScheduleResponseData;

/**
 * Class RoomScheduleView
 *
 * @package WhereIsMyTeacherBot\TelegramView
 */
class RoomScheduleView
{
    /**
     * @param RoomScheduleResponseData $scheduleResponseData
     *
     * @return string
     */
    public function toHtml(RoomScheduleResponseData $scheduleResponseData): string
    {
        $activities = $scheduleResponseData->getActivities();

        $activities = $activities->sortBy(function (ActivityData $activityData) {
            return [
                $this->dayOrder()[$activityData->getDay()],
                $activityData->getHourId() === 6 ? 0 : $activityData->getHourId(),
            ];
        });

        $activitiesByDay = $activities->groupBy(function (ActivityData $item) {
            return $item->getDay();
        });

        $lessonList = '';
        /**
         * @var string             $day
         * @var ActivityCollection $activityCollection
         */
        foreach ($activitiesByDay as $day => $activityCollection) {
            $lessonList .= "<b>{$day}:</b>" . PHP_EOL;
            foreach ($activityCollection->all() as $activityData) {
                $lessonList .= "<b>{$activityData->getHourName()}</b>: " . $activityData->getGroups() . PHP_EOL;
                $lessonList .= $activityData->getSubjectName() . PHP_EOL;
                $lessonList .= $activityData->getTag() . ', ' . $activityData->getTeacherName() . PHP_EOL;
            }

            $lessonList .= PHP_EOL;
        }

        return $lessonList;
    }

    /**
     * @return array
     */
    private function dayOrder(): array
    {
        return [
            'Понеділок 1' => 1,
            'Вівторок 1' => 2,
            'Середа 1' => 3,
            'Четвер 1' => 4,
            'П\'ятниця 1' => 5,
            'Понеділок 2' => 6,
            'Вівторок 2' => 7,
            'Середа 2' => 8,
            'Четвер 2' => 9,
            'П\'ятниця 2' => 10,
        ];
    }
}
