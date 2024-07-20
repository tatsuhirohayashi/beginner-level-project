<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_work',
        'end_work',
        'start_break',
        'break_duration',
        'work_duration',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
