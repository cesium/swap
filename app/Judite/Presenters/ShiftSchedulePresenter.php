<?php

namespace App\Judite\Presenters;

use Laracasts\Presenter\Presenter;

class ShiftSchedulePresenter extends Presenter
{
    /**
     * Get the string representation of the shift.
     *
     * @return string
     */
    public function inlineToString()
    {  
        $shiftschedule = $this->entity;
        $course = $shiftschedule->shift()->course()->name;
        $shift_tag = $shiftschedule->shift()->name;

        return $course.'@'.$shift_tag.'@'.$shiftschedule->weekday.'@'.($shiftschedule->start_time).'@'.($shiftschedule->end_time).'@'.($shiftschedule->location);
    }
}