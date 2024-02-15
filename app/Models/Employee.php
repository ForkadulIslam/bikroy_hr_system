<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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
        'department',
        'earned_leave_adjustment'
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
    public function maternity_leave_for_2nd_child(){
        return $this->hasMany(LeaveApplication::class, 'user_id','user_id')
            ->where('leave_type','Maternity Leave for 2nd Child')
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

    public function all_approved_leave(){
        return $this->hasMany(LeaveApplication::class, 'user_id','user_id')
            ->where('status', 'Approved');
    }

    public function getRemainingLeaveForCurrentYear()
    {
        //Log::info('Earnedleave adjustment: '. $this->earned_leave_adjustment);
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

        $earned_leave_per_day = 0.043;
        if ($joiningDate->diffInMonths($currentDate) > 12) {
            $opening_earned_leave = ($earned_leave_per_day * $joiningDate->diffInDays($currentDate)) + $earned_leave_balance;
            $opening_earned_leave -= $this->earned_leave_adjustment;
            $applied_earned_leave = $this->earned_leave()->sum('duration');
            $leave_details['earned_leave']['opening'] = round($opening_earned_leave, 1);
            $leave_details['earned_leave']['applied'] = $applied_earned_leave;
            $leave_details['earned_leave']['balance'] = round($opening_earned_leave, 1) - $applied_earned_leave;
        }else{
            $leave_details['earned_leave']['opening'] = 0;
            $leave_details['earned_leave']['applied'] = 0;
            $leave_details['earned_leave']['balance'] = 0;
        }

        // Calculate the sick leave based on the employee's joining date
        if ($joiningDate->year == $currentYear){
            $proratedSickLeaveDays = round(($joiningDate->diffInDays($yearEndDate) / 365) * $sick_leave_balance, 1);
            //return $proratedSickLeaveDays;
            $leave_details['sick_leave']['opening'] = $proratedSickLeaveDays;
            $leave_details['sick_leave']['applied'] = $this->sick_leave()->sum('duration');
            $leave_details['sick_leave']['balance'] = $proratedSickLeaveDays - $this->sick_leave()->sum('duration');
        }else{
            $applied_sick_leave = round($this->sick_leave()->whereYear('created_at', $currentYear)->sum('duration'),1);
            $leave_details['sick_leave']['opening'] = $sick_leave_balance;
            $leave_details['sick_leave']['applied'] = $applied_sick_leave;
            $leave_details['sick_leave']['balance'] = $sick_leave_balance - $applied_sick_leave;
        }

        // Calculate the casual leave based on the employee's joining date
        if ($joiningDate->year == $currentYear){
            $proratedCasualLeaveDays = round(($joiningDate->diffInDays($yearEndDate) / 365) * $casual_leave_balance, 1);
            $leave_details['casual_leave']['opening'] = $proratedCasualLeaveDays;
            $leave_details['casual_leave']['applied'] = $this->casual_leave()->sum('duration');
            $leave_details['casual_leave']['balance'] = $proratedCasualLeaveDays - $this->casual_leave()->sum('duration');
        }else{
            $applied_casual_leave = $this->casual_leave()->whereYear('created_at', $currentYear)->sum('duration');
            $leave_details['casual_leave']['opening'] = $casual_leave_balance;
            $leave_details['casual_leave']['applied'] = $applied_casual_leave;
            $leave_details['casual_leave']['balance'] = $casual_leave_balance - $applied_casual_leave;
        }

        // Calculate the paternal leave for 1st child
        if ($joiningDate->diffInMonths($currentDate) <= 6){
            $leave_details['paternal_leave_for_first_child']['opening'] = 0;
            $leave_details['paternal_leave_for_first_child']['applied'] = $this->paternal_leave_for_1st_child()->sum('duration');
            $leave_details['paternal_leave_for_first_child']['balance'] = 0 - $this->paternal_leave_for_1st_child()->sum('duration');
        }else{
            $applied_paternal_leave = $this->paternal_leave_for_1st_child()->whereYear('created_at', $currentYear)->sum('duration');
            $leave_details['paternal_leave_for_first_child']['opening'] = $paternal_leave_balance;
            $leave_details['paternal_leave_for_first_child']['applied'] = $applied_paternal_leave;
            $leave_details['paternal_leave_for_first_child']['balance'] = $paternal_leave_balance - $applied_paternal_leave;
        }

        // Calculate the paternal leave for 2nd child
        if ($joiningDate->diffInMonths($currentDate) <= 6){
            $leave_details['paternal_leave_for_second_child']['opening'] = 0;
            $leave_details['paternal_leave_for_second_child']['applied'] = $this->paternal_leave_for_2nd_child()->sum('duration');
            $leave_details['paternal_leave_for_second_child']['balance'] = 0 - $this->paternal_leave_for_2nd_child()->sum('duration');
        }else{
            $applied_paternal_leave = $this->paternal_leave_for_2nd_child()->whereYear('created_at', $currentYear)->sum('duration');
            $leave_details['paternal_leave_for_second_child']['opening'] = $paternal_leave_balance;
            $leave_details['paternal_leave_for_second_child']['applied'] = $applied_paternal_leave;
            $leave_details['paternal_leave_for_second_child']['balance'] = $paternal_leave_balance - $applied_paternal_leave;
        }

        // Calculate the maternity leave for 1st child
        if ($joiningDate->diffInMonths($currentDate) <= 6){
            $leave_details['maternity_leave_for_first_child']['opening'] = 0;
            $leave_details['maternity_leave_for_first_child']['applied'] = $this->maternity_leave_for_1st_child()->sum('duration');
            $leave_details['maternity_leave_for_first_child']['balance'] = 0 - $this->maternity_leave_for_1st_child()->sum('duration');
        }else{
            $applied_maternity_leave = $this->maternity_leave_for_1st_child()->whereYear('created_at', $currentYear)->sum('duration');
            $leave_details['maternity_leave_for_first_child']['opening'] = $maternity_leave_balance;
            $leave_details['maternity_leave_for_first_child']['applied'] = $applied_maternity_leave;
            $leave_details['maternity_leave_for_first_child']['balance'] = $maternity_leave_balance - $applied_maternity_leave;
        }

        // Calculate the maternity leave for 2nd child
        if ($joiningDate->diffInMonths($currentDate) <= 6){
            $leave_details['maternity_leave_for_second_child']['opening'] = 0;
            $leave_details['maternity_leave_for_second_child']['applied'] = $this->maternity_leave_for_2nd_child()->sum('duration');
            $leave_details['maternity_leave_for_second_child']['balance'] = 0 - $this->maternity_leave_for_2nd_child()->sum('duration');
        }else{
            $applied_maternity_leave = $this->maternity_leave_for_2nd_child()->whereYear('created_at', $currentYear)->sum('duration');
            $leave_details['maternity_leave_for_second_child']['opening'] = $maternity_leave_balance;
            $leave_details['maternity_leave_for_second_child']['applied'] = $applied_maternity_leave;
            $leave_details['maternity_leave_for_second_child']['balance'] = $maternity_leave_balance - $applied_maternity_leave;
        }

        // Calculate the work from home
        $applied_work_from_home = $this->applied_work_from_home()->whereYear('created_at', $currentYear)->sum('duration');
        $leave_details['applied_work_from_home']['opening'] = $applied_work_from_home;
        $leave_details['applied_work_from_home']['applied'] = $applied_work_from_home;
        $leave_details['applied_work_from_home']['balance'] = $applied_work_from_home;

        // Calculate the non paid leave
        $applied_non_paid_leave = $this->applied_non_paid_leave()->whereYear('created_at', $currentYear)->sum('duration');
        $leave_details['applied_non_paid_leave']['opening'] = $applied_non_paid_leave;
        $leave_details['applied_non_paid_leave']['applied'] = $applied_non_paid_leave;
        $leave_details['applied_non_paid_leave']['balance'] = $applied_non_paid_leave;

        return $leave_details;
    }

    public function attendance(){
        return $this->hasMany(Attendance::class, 'attendance_id', 'attendance_id');
    }

}
