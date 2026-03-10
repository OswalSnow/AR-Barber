<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['customer_name', 'customer_phone', 'starts_at', 'status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

