<?php

namespace App\Services;

trait MonthDaysService
{
    public function getMonthDays(int $month)
    {
        $year = date('Y');

        if ($month == 2) {
            if ($year % 4 == 0) {
                return 29;
            } else {
                return 28;
            }
        }
        switch ($month) {
            case 1:
                return 31;
                break;
            case 3:
                return 31;
                break;
            case 4:
                return 30;
                break;
            case 5:
                return 31;
                break;
            case 6:
                return 30;
                break;
            case 7:
                return 31;
                break;
            case 8:
                return 31;
                break;
            case 9:
                return 30;
                break;
            case 10:
                return 31;
                break;
            case 11:
                return 30;
                break;
            case 12:
                return 31;
                break;
        }
    }
}
