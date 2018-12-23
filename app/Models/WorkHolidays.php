<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkHolidays extends Model
{
    protected $guarded = ['id'];
    protected $table = 'office_holidays';

    //protected  $dates = ['date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'holiday_for', 'id');
    }
}
