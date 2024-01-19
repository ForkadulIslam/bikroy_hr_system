<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ['attendance_id', 'attendance_date', 'attendance_time'];

    public function Employee(){
        return $this->belongsTo(Employee::class, 'attendance_id', 'attendance_id');
    }
}
