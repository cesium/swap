<?php

namespace App\Imports;

use Maatwebsite\Excel\Row;
use Illuminate\Support\Str;
use App\Judite\Models\ShiftSchedule;
use App\Judite\Models\Course;
use App\Judite\Models\Shift;
use App\Exceptions\InvalidFieldValueException;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class ShiftScheduleImport implements OnEachRow, WithHeadingRow, ToModel
{
    /**
     * The enrollment row to import.
     *
     * @param \Maatwebsite\Excel\Row $row
     */

    //CSV FORMAT : course,shift_tag,weekday,start_time,end_time,location
    public function model(Row $row){

            $course = Course::whereCode($row['course_id'])->first();
            if ($course === null) {
                $exception = new InvalidFieldValueException();
                $exception->setField('Course ID', $row['course_id'], "The course {$row['course_id']} does not exist. (at line {$index})");
                throw $exception;
            }
            
            if ($row['shift'] !== null) {
                $shift = $course->getShiftByTag($row['shift']);
    
                if ($shift === null) {
                    $shift = Shift::make(['tag' => $row['shift']]);
                    $course->addShift($shift);
                }
            }else{
                $shift = null;
            }


            return new ShiftSchedule([
                'shift_id' => $shift,
                'weekday' => $row['weekday'],
                'start_time' => $row['start_time'],
                'end_time' => $row['end_time' ],
                'location' => $row['location'],
            ]);

    } 
}
