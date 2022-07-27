<?php

namespace App\Judite\Models;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use App\Judite\Presenters\Shift_SchedulePresenter;


class ShiftSchedule extends Model
{
    use PresentableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'shifts_schedule';

    protected $fillable = [
        'weekday', 
        'start_time',
        'end_time',
        'location'
    ];
    
    /**
     * The presenter for this entity.
     *
     * @var string
     */
    protected $presenter = Shift_SchedulePresenter::class;

    /**
     * Get shift of this schedule.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

}
