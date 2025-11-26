<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GymClass extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'name',
        'description',
        'capacity',
        'schedule',
        'trainer_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'capacity' => 'integer',
    ];

    /**
     * RELACIONES
     */

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function schedules()
    {
        return $this->hasMany(ClassSchedule::class, 'class_id');
    }
}
