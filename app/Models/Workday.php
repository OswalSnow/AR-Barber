<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workday extends Model
{
    protected $fillable = ['user_id', 'day', 'is_open', 'start_time', 'end_time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
