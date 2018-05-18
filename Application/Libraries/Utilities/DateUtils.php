<?php

namespace Libraries\Utilities;

class DateUtils
{

    /**
     * Gets difference in days between two dates
     * @param string $fromDate
     * @param string $toDate
     * @return int
     */
    public static function daysBetweenDates(string $fromDate, string $toDate): int
    {
        $from = new \DateTime($fromDate);
        $to = new \DateTime($toDate);

        $diff = $from->diff($to);
        return $diff->format("%a");
    }

    /**
     * Gets day of week as string
     * @param string $dateString
     * @param string $lang
     * @return string
     */
    public static function getDayOfWeek(string $dateString, string $lang = 'en'): string
    {
        switch ($lang) {
            case 'pl':
                $days = ['poniedziałek', 'wtorek', 'środa', 'czwartek', 'piątek', 'sobota', 'niedziela'];
                break;

            case 'en':
                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                break;

            default:
                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                break;
        }

        $result = date('\dN', strtotime($dateString));
        $result = str_replace(['d1', 'd2', 'd3', 'd4', 'd5', 'd6', 'd7'], $days, $result);

        return $result;
    }

    /**
     * Gets date formatted to polish
     * @param string $dateString
     * @param bool $includeDayName
     * @param bool $shortDayName
     * @return string
     */
    public static function formatToPolish(string $dateString, bool $includeDayName = false, bool $shortDayName = false): string
    {
        $days = [];
        $days[true] = ['pn.', 'wt.', 'śr.', 'czw.', 'pt.', 'sob.', 'niedz.'];
        $days[false] = ['poniedziałek', 'wtorek', 'środa', 'czwartek', 'piątek', 'sobota', 'niedziela'];

        if ($includeDayName) {
            $result = date('\dN j.m.Y', strtotime($dateString));
            $result = str_replace(['d1', 'd2', 'd3', 'd4', 'd5', 'd6', 'd7'], $days[$shortDayName], $result);
        } else {
            $result = date('j.m.Y', strtotime($dateString));
        }

        return $result;
    }

}
