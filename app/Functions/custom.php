<?php

use Illuminate\Support\Facades\File;


function generate_asset_url($path){
    return 'https://bikroyit.com/adcrm_assets/bikroy/'.$path;
}
function menu_array(){
    return [
        /**=======ADMIN MENU========**/
        [
            'role_id' => 1,
            'label'=>'Leave Management',
            'icon'=>'airline_seat_flat',
            'link'=>url('module/leave'),
        ],
        [
            'role_id' => 1,
            'label'=>'Manage Employee',
            'icon'=>'badge',
            'link'=>url('/module/employee')
        ],

        [
            'role_id' => 1,
            'label'=>'Manage Team Leader',
            'icon'=>'badge',
            'link'=>url('/module/manage_team_leader')
        ],

        [
            'role_id' => 1,
            'label'=>'Manage Holy day',
            'icon'=>'date_range',
            'link'=>url('/module/holiday')
        ],

        /**=======EXECUTIVE MENU========**/
        [
            'role_id' => 2,
            'label'=>'Leave Management',
            'icon'=>'assignment_turned_in',
            'link'=>url('module/leave'),
        ],


        /**=======TEAM LEADER MENU========**/
        [
            'role_id' => 3,
            'label'=>'Leave Management',
            'icon'=>'assignment_turned_in',
            'link'=>url('module/leave'),
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
        'Management' => 'Management'
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

