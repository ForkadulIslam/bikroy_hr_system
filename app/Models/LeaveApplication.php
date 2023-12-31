<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'leave_type',
        'from_date',
        'to_date',
        'duration',
        'is_half_day',
        'half_day_type',
        'reason',
        'status',
        'status_updated_by'
    ];
}
