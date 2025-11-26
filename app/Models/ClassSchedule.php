<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    protected $fillable = ['class_id', 'day_of_week', 'day_name', 'start_time', 'end_time'];

    public function class()
    {
        return $this->belongsTo(GymClass::class);
    }
}
