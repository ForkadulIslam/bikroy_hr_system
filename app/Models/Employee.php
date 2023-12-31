<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'attendance_id',
        'fathers_name',
        'phone_no',
        'date_of_birth',
        'religion',
        'gender',
        'category',
        'tin_no',
        'date_of_joining',
        'end_of_contract_date',
        'marital_status',
        'payment_mode',
        'vendor_code',
        'designation',
        'department'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function earned_leave(){
        return $this->hasMany(LeaveApplication::class, 'user_id','user_id')
            ->where('leave_type','Earned Leave')
            ->where('status', 'Approved');
    }
    public function sick_leave(){
        return $this->hasMany(LeaveApplication::class, 'user_id','user_id')
            ->where('leave_type','Sick Leave')
            ->where('status', 'Approved');
    }
    public function casual_leave(){
        return $this->hasMany(LeaveApplication::class, 'user_id','user_id')
            ->where('leave_type','Casual Leave')
            ->where('status', 'Approved');
    }
    public function paternal_leave_for_1st_child(){
        return $this->hasMany(LeaveApplication::class, 'user_id','user_id')
            ->where('leave_type','Paternal Leave for 1st Child')
            ->where('status', 'Approved');
    }
    public function paternal_leave_for_2nd_child(){
        return $this->hasMany(LeaveApplication::class, 'user_id','user_id')
            ->where('leave_type','Paternity Leave for 2nd Child')
            ->where('status', 'Approved');
    }
    public function maternity_leave_for_1st_child(){
        return $this->hasMany(LeaveApplication::class, 'user_id','user_id')
            ->where('leave_type','Maternity Leave for 1st Child')
            ->where('status', 'Approved');
    }
    public function applied_work_from_home(){
        return $this->hasMany(LeaveApplication::class, 'user_id','user_id')
            ->where('leave_type','Work From Home')
            ->where('status', 'Approved');
    }
    public function applied_non_paid_leave(){
        return $this->hasMany(LeaveApplication::class, 'user_id','user_id')
            ->where('leave_type','Non Paid Leave')
            ->where('status', 'Approved');
    }

    public function getRemainingLeaveForCurrentYear()
    {
        $leave_details = [];
        $earned_leave_balance = 16;
        $sick_leave_balance = 14;
        $casual_leave_balance = 10;
        $paternal_leave_balance = 5;
        $maternity_leave_balance = 113;
        $joiningDate = Carbon::parse($this->date_of_joining);
        $currentDate = Carbon::now();
        $currentYear = $currentDate->year;
        $yearStartDate = Carbon::createFromDate($currentYear, 1, 1);
        $yearEndDate = Carbon::createFromDate($currentYear, 12, 31);


        $total_earned_leave = 0;
        $earned_leave_per_day = 0.043;
        if ($joiningDate->diffInMonths($currentDate) > 12) {
            $total_earned_leave += ($earned_leave_per_day * $joiningDate->diffInDays($currentDate)) + $earned_leave_balance;
            $total_earned_leave -= $this->earned_leave->count();
        }

        $remainingEarnedLeave = round($total_earned_leave, 1);
        $leave_details['earned_leave'] = $remainingEarnedLeave;

        // Calculate the sick leave based on the employee's joining date
        if ($joiningDate->year == $currentYear){
            $proratedSickLeaveDays = ($joiningDate->diffInDays($yearEndDate) / 365) * $sick_leave_balance;
        }else{
            $proratedSickLeaveDays = $sick_leave_balance;
        }

        $proratedSickLeaveDays -= $this->sick_leave->count();

        $remainingSickLeave = round($proratedSickLeaveDays, 1);
        $leave_details['sick_leave'] = $remainingSickLeave;
        // Calculate the casual leave based on the employee's joining date
        if ($joiningDate->year == $currentYear){
            $proratedCasualLeaveDays = ($joiningDate->diffInDays($yearEndDate) / 365) * $casual_leave_balance;
        }else{
            $proratedCasualLeaveDays = $casual_leave_balance;
        }
        $proratedCasualLeaveDays -= $this->casual_leave->count();
        $remainingCasualLeave = round(max($proratedCasualLeaveDays, 0), 1);
        $leave_details['casual_leave'] = $remainingCasualLeave;

        // Calculate the paternal leave for 1st child
        if ($joiningDate->diffInMonths($currentDate) <= 6){
            $remainingPaternalLeave = 0;
        }else{
            $remainingPaternalLeave = $paternal_leave_balance;
        }
        $remainingPaternalLeave -= $this->paternal_leave_for_1st_child->count();
        $leave_details['paternal_leave_for_first_child'] = $remainingPaternalLeave;

        // Calculate the paternal leave for 2nd child
        if ($joiningDate->diffInMonths($currentDate) <= 6){
            $remainingPaternalLeave = 0;
        }else{
            $remainingPaternalLeave = $paternal_leave_balance;
        }
        $remainingPaternalLeave -= $this->paternal_leave_for_2nd_child->count();
        $leave_details['paternal_leave_for_second_child'] = $remainingPaternalLeave;

        // Calculate the maternity leave for 1st child
        if ($joiningDate->diffInMonths($currentDate) <= 6){
            $remainingMaternityLeave = 0;
        }else{
            $remainingMaternityLeave = $maternity_leave_balance;
        }
        $remainingMaternityLeave -= $this->maternity_leave_for_1st_child->count();
        $leave_details['maternity_leave_for_first_child'] = $remainingMaternityLeave;

        // Calculate the maternity leave for 2nd child
        if ($joiningDate->diffInMonths($currentDate) <= 6){
            $remainingMaternityLeave = 0;
        }else{
            $remainingMaternityLeave = $maternity_leave_balance;
        }
        $remainingMaternityLeave -= $this->maternity_leave_for_1st_child->count();
        $leave_details['maternity_leave_for_second_child'] = $remainingMaternityLeave;

        $leave_details['applied_work_from_home'] = $this->applied_work_from_home->count();
        $leave_details['applied_non_paid_leave'] = $this->applied_non_paid_leave->count();

        return $leave_details;

    }

}
