<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Admin;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HolidayCalendarController;
use App\Http\Controllers\LeaveController;


Route::get('/', [AuthController::class, 'index']);
Route::get('admin', [Admin::class, 'index']);
Route::post('/login',[AuthController::class, 'login']);
Route::get('/logout',[AuthController::class, 'logout']);


Route::group(['prefix'=>'module'],function(){
    Route::resource('employee', EmployeeController::class);
    Route::post('/check-email-availability', [EmployeeController::class, 'checkEmailAvailability'])->name('check.email.availability');
    Route::get('manage_team_leader',[EmployeeController::class, 'manage_team_leader']);
    Route::get('create_team_leader',[EmployeeController::class, 'create_team_leader']);
    Route::get('team_leader_name_suggestion',[EmployeeController::class,'team_leader_name_suggestion']);
    Route::post('save_team_leader',[EmployeeController::class, 'save_team_leader']);
    Route::get('delete_team_leader/{id}',[EmployeeController::class, 'delete_team_leader']);
    Route::get('leave/get_leave_count',[LeaveController::class, 'get_leave_count']);
    Route::resource('leave',LeaveController::class);
    Route::get('delete_leave/{leave_id}',[LeaveController::class,'destroy']);
    Route::get('mange_team_leave',[LeaveController::class,'mange_team_leave']);
    Route::get('team_leave_balance',[LeaveController::class,'team_leave_balance']);
    Route::get('show_team_leave_balance/{employee_id}',[LeaveController::class,'show_team_leave_balance']);
    Route::get('update_leave_status/{leave_id}/{leave_status}', [LeaveController::class, 'update_leave_status']);
    Route::resource('holiday', HolidayCalendarController::class);
    Route::get('delete_holiday/{id}',[HolidayCalendarController::class,'destroy']);
    Route::get('manage_tl_leave',[LeaveController::class, 'manage_tl_leave']);
    Route::get('tl_leave_balance',[LeaveController::class, 'tl_leave_balance']);

    Route::get('employee_excel_import',[EmployeeController::class, 'employee_excel_import']);
    Route::post('post_employee_excel', [EmployeeController::class, 'post_employee_excel']);
    Route::get('leave_report',[LeaveController::class, 'leave_report']);

    Route::resource('attendance', AttendanceController::class);
    Route::get('attendance_log_by_user/{user_id}',[AttendanceController::class, 'attendance_log_by_user']);

});




