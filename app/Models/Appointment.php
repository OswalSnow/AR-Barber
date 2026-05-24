<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;

    protected $fillable = ['customer_name', 'customer_phone', 'servicio', 'starts_at', 'ends_at', 'status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

