<?php
declare(strict_types = 1);

namespace WhereIsMyTeacherBot\Model;

use Goutte;
use Symfony\Component\DomCrawler\Crawler;
use WhereIsMyTeacherBot\Dictionary\FreeChoiceSubjectDictionary;
use WhereIsMyTeacherBot\Entity\FreeChoiceSubjectSearch;

/**
 * Class TeacherParser
 *
 * @package WhereIsMyTeacherBot\Model
 */
class TeacherParser
{
    private const SCHEDULE = 'https://rozklad.ztu.edu.ua/schedule/teacher/';

    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @var string
     */
    private $teacherName;

    /**
     * TeacherParser constructor.
     *
     * @param string $teacherName
     */
    public function __construct(string $teacherName)
    {

        $gouttleClient = new Goutte\Client();
        $this->teacherName = $teacherName;
        $this->crawler = $gouttleClient->request(OAUTH_HTTP_METHOD_GET, self::SCHEDULE . $teacherName);
    }

    /**
     * @return string
     */
    public function parse(): string
    {
        $currentWeek = $this->getCurrentWeek();
        $lessons = $this->getLessons($this->teacherName);

        if (!$lessons) {
            return "$currentWeek для даного викладача - тиждень без пар";
        }

        $lessonsList = "<b>Показано $currentWeek</b>\n";

        foreach ($this->getGroupedLessons($lessons) as $day => $dayLessons) {
            $lessonsList .= "\n<b>$day:</b>\n";
            foreach ($dayLessons as $time => $pqLesson) {
                $text = trim($pqLesson->textContent);

                if (mb_strpos($text, 'Вибіркова дисципліна')!==false) {

                    $entity = new FreeChoiceSubjectSearch(
                        $currentWeek,
                        $this->teacherName,
                        explode('-',$time)[0],
                        $day
                    );

                    $text = FreeChoiceSubjectDictionary::getSubjectByFreeChoiceSearchEntity($entity) . PHP_EOL . $text;
                }

                $text = PHP_EOL . "<b>$time:</b> " . str_replace($this->teacherName, '', $text);

                $lessonsList .= $text;
            }
        }

        $teacherUrl = self::SCHEDULE . $this->teacherName;
        $lessonsList .= PHP_EOL . "<a href='$teacherUrl'>Повний розклад викладача</a>";

        return $lessonsList;
    }

    /**
     * @return string
     */
    private function getCurrentWeek(): string
    {
        return $this->crawler->filter('th.selected')
            ->parents()
            ->filter('table')
            ->previousAll()
            ->filter('h2')
            ->text();
    }

    /**
     * @param string $teacher
     *
     * @return Crawler
     */
    private function getLessons(string $teacher): Crawler
    {
        return $this->crawler->filter('th.selected')
            ->parents()
            ->filter('table')
            ->children()
            ->filter("td:contains(\"$teacher\")");
    }

    /**
     * @param Crawler $lessons
     *
     * @return \DOMElement[][]
     */
    protected function getGroupedLessons(Crawler $lessons): array
    {
        $groupedLessons = [];

        foreach ($lessons as $lesson) {
            $hours = $lesson->getAttribute('hour');
            $day = trim($lesson->getAttribute('day'), ' 12');
            $groupedLessons[$day][$hours] = $lesson;
        }

        return $groupedLessons;
    }
}
