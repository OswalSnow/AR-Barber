<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'duration_minutes'];

    public function appointments()
    {
        return $this->belongsToMany(Appointment::class);
    }
}