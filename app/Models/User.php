<?php

namespace App\Models;

use Carbon\Carbon;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    public function roleUser()
    {
        return $this->hasOne(RoleUser::class, 'user_id', 'id');
    }

    public function userInfo()
    {
        return $this->hasOne(UserInfo::class, 'user_id', 'id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id', 'id');
    }

    public function baseSalary()
    {
        return $this->hasOne(BaseSalary::class, 'user_id', 'id');
    }

    public function baseSalaries()
    {
        return $this->hasMany(BaseSalary::class, 'user_id', 'id');
    }


    public function workHolidays()
    {
        return $this->hasMany(WorkHolidays::class, 'holiday_for', 'id')
            ->where('holiday_for' != 'ALL')
            ->orWhere('holiday_for' !=  null);
    }


    public function todayAttendance()
    {
        return $this->hasOne(Attendance::class, 'user_id', 'id')
            ->whereDay('work_date', Carbon::now()->day);
    }

}
