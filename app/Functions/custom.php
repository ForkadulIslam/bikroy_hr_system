<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


function generate_asset_url($path){
    return 'https://bikroyit.com/adcrm_assets/bikroy/'.$path;
}
function menu_array(){
    return [
        /**=======ADMIN MENU========**/
        [
            'label'=>'Leave',
            'role_id'=>1,
            'icon'=>'perm_identity',
            'link'=>'#',
            'sub'=>[
                [
                    'label'=>'Create Application',
                    'link'=>url('module/leave/create')
                ],
                [
                    'label'=>'My Application',
                    'link'=>url('module/leave')
                ],
                [
                    'label'=>'Department wise leave',
                    'link'=>url('module/leave_report')
                ]
            ]
        ],
        [
            'role_id' => 1,
            'label'=>'Manage Employee',
            'icon'=>'badge',
            'link'=>'#',
            'sub'=>[
                [
                    'label'=>'Create Employee',
                    'link'=>url('/module/employee/create')
                ],
                [
                    'label'=>'Upload Employee Data',
                    'link'=>url('/module/employee_excel_import')
                ],
                [
                    'label'=>'Employee List',
                    'link'=>url('/module/employee')
                ]
            ]
        ],

        [
            'role_id' => 1,
            'label'=>'Manage Team Leader',
            'icon'=>'badge',
            'link'=>url('/module/manage_team_leader')
        ],

        [
            'role_id' => 1,
            'label'=>'Attendance',
            'icon'=>'badge',
            'link'=>'#',
            'sub'=>[
                [
                    'label' => 'Report',
                    'link' =>url('/module/attendance')
                ],
                [
                    'label' => 'Upload',
                    'link' =>url('/module/attendance/create')
                ]
            ]
        ],

        [
            'role_id' => 1,
            'label'=>'Manage Holy day',
            'icon'=>'date_range',
            'link'=>url('/module/holiday')
        ],
        [
            'role_id' => 1,
            'label'=>'Change Password',
            'icon'=>'lock',
            'link'=>url('/module/change_password')
        ],


        /**=======EXECUTIVE MENU========**/
        [
            'label'=>'Manage My Leave',
            'role_id'=>2,
            'icon'=>'perm_identity',
            'link'=>'#',
            'sub'=>[
                [
                    'label'=>'Create Application',
                    'link'=>url('module/leave/create')
                ],
                [
                    'label'=>'My Application',
                    'link'=>url('module/leave')
                ],
            ],
        ],
        [
            'role_id' => 2,
            'label'=>'Change Password',
            'icon'=>'lock',
            'link'=>url('/module/change_password')
        ],


        /**=======TEAM LEADER MENU========**/
        [
            'role_id' => 3,
            'label'=>'Leave Management',
            'icon'=>'assignment_turned_in',
            'link'=>url('module/leave'),
        ],
        [
            'role_id' => 3,
            'label'=>'Change Password',
            'icon'=>'lock',
            'link'=>url('/module/change_password')
        ],

    ];
}

function leave_type_array(){
    return [
        'Casual Leave' => 'Casual Leave',
        'Sick Leave' => 'Sick Leave',
        'Earned Leave' => 'Earned Leave',
        'Paternal Leave for 1st Child' => 'Paternal Leave for 1st Child',
        'Paternity Leave for 2nd Child' => 'Paternity Leave for 2nd Child',
        'Maternity Leave for 1st Child' => 'Maternity Leave for 1st Child',
        'Maternity Leave for 2nd Child' => 'Maternity Leave for 2nd Child',
        'Work From Home' => 'Work From Home',
        'Non Paid Leave' => 'Non Paid Leave',
    ];
}
function department_list(){
    return [
        'Business Development' => 'Business Development',
        'Corporate Sales & KAM' => 'Corporate Sales & KAM',
        'Finance & Reporting' => 'Finance & Reporting',
        'Marketing' => 'Marketing',
        'Member Relation' => 'Member Relation',
        'Operations' => 'Operations',
        'Product Development & QA' => 'Product Development & QA',
        'Management' => 'Management',
        'HR & Culture' => 'HR & Culture',
        'Telesales' => 'Telesales',
        'Outstation' => 'Outstation'
    ];
}
function designation_list(){
    return [
        'Junior Executive' => 'Junior Executive',
        'Executive' => 'Executive',
        'Senior Executive (L1)' => 'Senior Executive (L1)',
        'Senior Executive (L2)' => 'Senior Executive (L2)',
        'Assistant Manager' => 'Assistant Manager',
        'Deputy Manager' => 'Deputy Manager',
        'Manager' => 'Manager',
        'Senior Manager' => 'Senior Manager',
        'Assistant Director' => 'Assistant Director',
        'Director' => 'Director',
        'CEO' => 'CEO',
    ];
}
function get_month_list(){
    $month = [];

    for ($m=1; $m<=12; $m++) {
        $name  = date('F', mktime(0,0,0,$m, 1, date('Y')));
        $month[$name] = $name;
    }
    return $month;
}
function get_year_list(){
    $month_list =  range(Carbon::now()->year, 2023);
    $months  = [];
    foreach ($month_list as $item){
        $months[$item] = $item;
    }
    return $months;
}

function sendMail($recipientEmail, $subject, $htmlPart) {
    //return $htmlPart;
    $endpoint = 'https://hr.bikroytech.com/mailer_api/index.php';
    $response = Http::asForm()->post($endpoint, [
        'on_create_leave_application' => true,
        'to' => $recipientEmail,
        'subject' => $subject,
        'html_part' => $htmlPart
    ]);
    Log::info($response->json());
    return $response->json(); // Return the JSON response
}

