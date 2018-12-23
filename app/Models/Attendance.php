<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = ['id'];

    //protected $dates = ['work_date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    /**
     * Return Time in seconds
     * @param $attendance
     * @return int
     */
    public static function getTotalWorkTime($attendance)
    {
        if($attendance->status == 'start' && $attendance->break_entry_time == null){
            $startTime = Carbon::createFromTimestamp($attendance->entry_time/1000);
            $now = Carbon::now();
            $totalDuration = $now->diffInSeconds($startTime);
            return $totalDuration;
        }elseif ($attendance->status == 'start' && $attendance->break_entry_time != null){
            $startTime = Carbon::createFromTimestamp($attendance->break_entry_time/1000);
            $now = Carbon::now();
            $totalDuration = $now->diffInSeconds($startTime) + $attendance->total_worked_time;
            return $totalDuration;
        }
        else{
            return $attendance->total_worked_time;
        }
    }

}
