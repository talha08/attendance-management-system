<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $guarded = ['id'];

    public function userInfo()
    {
        return $this->hasOne(UserInfo::class, 'position_id', 'id');
    }
}
