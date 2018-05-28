<?php
declare(strict_types=1);

namespace WhereIsMyTeacherBot\Model;

use phpQueryObject;

class TeacherParser
{
    public static function parse(string $url, string $teacher): string
    {
        \phpQuery::newDocumentFileHTML($url);

        $currentTable = pq('th.selected')->parents('table');
        $currentWeek = $currentTable->prev()->text();

        $lessons = pq('th.selected')->parents('table')->find("td:contains(\"$teacher\")");

        if (!$lessons) {
            return "$currentWeek для даного викладача - тиждень без пар";
        }

        $lessonsList = "<b>Показано $currentWeek</b>\n";

        foreach (self::getGroupedLessons($lessons) as $day => $dayLessons) {
            $lessonsList .= "\n<b>$day:</b>\n";
            /** @var phpQueryObject $pqLesson */
            foreach ($dayLessons as $time => $pqLesson) {
                $lessonsList .= "\n<b>$time:</b> " . trim(str_replace($teacher, '', $pqLesson->text())) . "\n";
            }
        }

        return $lessonsList;
    }

    /**
     * @param \phpQueryObject $lessons
     *
     * @return array
     */
    protected static function getGroupedLessons(phpQueryObject $lessons): array
    {
        $groupedLessons = [];

        foreach ($lessons as $lesson) {
            $pqLesson = pq($lesson);
            $hours = $pqLesson->attr('hour');
            $day = trim($pqLesson->attr('day'), ' 12');
            $groupedLessons[$day][$hours] = $pqLesson;
        }

        return $groupedLessons;
    }
}
