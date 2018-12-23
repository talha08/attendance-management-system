<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $guarded = ['id'];
    protected $table = 'user_info';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

}
