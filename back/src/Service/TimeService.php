<?php

namespace App\Service;

class TimeService
{
    /**
     * Returns a duration in a human readable format
     *
     * @param   int         $duration
     * @return  string      (ex: 1h30min)
     */
    public function getDuration($duration)
    {
        $hours = floor($duration / 3600);
        $minutes = floor(($duration / 60) % 60);

        if ($hours > 0) {
            return $hours . 'h' . $minutes . 'min';
        } else {
            return $minutes . 'min';
        }
    }

    /**
     * Returns a duration in minutes
     * 
     * @param   string      $duration   (ex: 130 min)
     * @return  int
     */
    public function getDurationInMinutes($duration)
    {
        $duration = explode(' ', $duration);
        return (int) $duration[0];
    }
}
