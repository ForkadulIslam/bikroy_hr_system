﻿@extends('admin.layouts.form')
@section('custom_page_style')
    <style>
        table td{
            vertical-align: middle!important;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid" id="app">
        <div class="row clearfix">
            <div class="col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2 class="text-muted">{!! strtoupper(Auth()->user()->name) !!}</h2>
                        <p class="">Designation: <span class="font-12 text-muted">{!! Auth::user()->employee->designation !!}</span></p>
                        <p>Department: <span class="font-12 text-muted">{!! Auth::user()->employee->department !!}</span></p>
                    </div>
                </div>
            </div>
        </div>
        @if(\App\Models\TeamLeader::where('user_id',auth()->user()->id)->first())
            <div class="row clearfix">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix">
                                <div class="col-xs-12">
                                    <h5 class="">Pending Leave Application</h5>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="bg-grey">
                                        <tr class="font-12">
                                            <th>Employee</th>
                                            <th>Leave type</th>
                                            <th>Reason</th>
                                            <th>From date</th>
                                            <th>To date</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th>Submitted At</th>
                                            <th>Option</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $team_leader = \App\Models\TeamLeader::where('user_id',auth()->user()->id)->first();
                                            $pending_leave_application = [];
                                            if($team_leader){
                                               $department =  $team_leader->department;
                                               $user_ids =  \App\Models\Employee::where('department',$department)->where('user_id','!=',auth()->user()->id)->pluck('user_id');
                                               //return $user_ids;
                                               $pending_leave_application =  \App\Models\LeaveApplication::orderBy('id','desc')->where('status','Pending')->whereIn('user_id',$user_ids)->paginate(20);
                                            }
                                        @endphp
                                        @foreach($pending_leave_application as $i=>$result)
                                            <tr class="font-12">
                                                <td>{!! $result->user->name !!}</td>
                                                <td>{!! $result->leave_type !!}</td>
                                                <td>{!! $result->reson !!}</td>
                                                <td>{!! $result->from_date !!}</td>
                                                <td>{!! $result->to_date !!}</td>
                                                <td>{!! $result->duration !!}</td>
                                                <td>
                                                    @if($result->status == 'Approved')
                                                        <span class="badge bg-green">{!! $result->status !!}</span>
                                                    @elseif($result->status == 'Rejected')
                                                        <span class="badge bg-red">{!! $result->status !!}</span>
                                                    @elseif($result->status == 'Pending')
                                                        <span class="badge bg-orange">{!! $result->status !!}</span>
                                                    @endif
                                                </td>
                                                <td>{!! $result->created_at->toDateString() !!}</td>
                                                <td>
                                                    {!! Form::select('leave_type', ['Approved'=>'Approved', 'Rejected'=>'Rejected'], $result->status, ['class'=>'form-control selectpicker', 'required'=>'true', 'v-model'=>'selectedStatus', '@change'=>'on_update_status('.$result->id.')','placeholder'=>'--Please Select--']) !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @elseif(auth()->user()->employee->designation == 'CEO')
                @php
                    $team_leader_ids = \App\Models\TeamLeader::pluck('user_id');
                    //print_r($team_leader_ids);
                    $pending_leave_application =  \App\Models\LeaveApplication::orderBy('id','desc')->where('status','Pending')->whereIn('user_id',$team_leader_ids)->paginate(20);
                @endphp
            @if(count($pending_leave_application) > 0)
            <div class="row clearfix">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix">
                                <div class="col-xs-12">
                                    <h5 class="">Pending Leave Application</h5>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="bg-grey">
                                        <tr class="font-12">
                                            <th>Employee</th>
                                            <th>Leave type</th>
                                            <th>Reason</th>
                                            <th>From date</th>
                                            <th>To date</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th>Submitted At</th>
                                            <th>Option</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pending_leave_application as $i=>$result)
                                            <tr class="font-12">
                                                <td>{!! $result->user->name !!}</td>
                                                <td>{!! $result->leave_type !!}</td>
                                                <td>{!! $result->reson !!}</td>
                                                <td>{!! $result->from_date !!}</td>
                                                <td>{!! $result->to_date !!}</td>
                                                <td>{!! $result->duration !!}</td>
                                                <td>
                                                    @if($result->status == 'Approved')
                                                        <span class="badge bg-green">{!! $result->status !!}</span>
                                                    @elseif($result->status == 'Rejected')
                                                        <span class="badge bg-red">{!! $result->status !!}</span>
                                                    @elseif($result->status == 'Pending')
                                                        <span class="badge bg-orange">{!! $result->status !!}</span>
                                                    @endif
                                                </td>
                                                <td>{!! $result->created_at->toDateString() !!}</td>
                                                <td>
                                                    {!! Form::select('leave_type', ['Approved'=>'Approved', 'Rejected'=>'Rejected'], $result->status, ['class'=>'form-control selectpicker', 'required'=>'true', 'v-model'=>'selectedStatus', '@change'=>'on_update_status('.$result->id.')','placeholder'=>'--Please Select--']) !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endif
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <h5 class="">Welcome on Board</h5>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <table class="table table-bordered table-striped font-12 bg-grey">
                                    <thead>
                                    <tr class="bg-grey">
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Department</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <h5 class="">My Leave Balance</h5>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <table class="table table-bordered table-hovered table-condenced">
                                    <thead class="font-13 bg-grey">
                                    <tr>
                                        <th>Type</th>
                                        <th>Opening</th>
                                        <th>Avail</th>
                                        <th>Balance</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="font-11">
                                        <td>Casual Leave</td>
                                        <td>{!! $leave_details['casual_leave']['opening'] !!}</td>
                                        <td>{!! $leave_details['casual_leave']['applied'] !!}</td>
                                        <td>{!! $leave_details['casual_leave']['balance'] !!}</td>
                                    </tr>
                                    <tr class="font-11">
                                        <td>Sick Leave</td>
                                        <td>{!! $leave_details['sick_leave']['opening'] !!}</td>
                                        <td>{!! $leave_details['sick_leave']['applied'] !!}</td>
                                        <td>{!! $leave_details['sick_leave']['balance'] !!}</td>
                                    </tr>
                                    <tr class="font-11">
                                        <td>Earned Leave</td>
                                        <td>{!! $leave_details['earned_leave']['opening'] !!}</td>
                                        <td>{!! $leave_details['earned_leave']['applied'] !!}</td>
                                        <td>{!! $leave_details['earned_leave']['balance'] !!}</td>
                                    </tr>
                                    @if(auth()->user()->employee->gender == 'Male')
                                        <tr class="font-11">
                                            <td>Paternal Leave for 1st Child</td>
                                            <td>{!! $leave_details['paternal_leave_for_first_child']['opening'] !!}</td>
                                            <td>{!! $leave_details['paternal_leave_for_first_child']['applied'] !!}</td>
                                            <td>{!! $leave_details['paternal_leave_for_first_child']['balance'] !!}</td>
                                        </tr>
                                        <tr class="font-11">
                                            <td>Paternal Leave for 2nd Child</td>
                                            <td>{!! $leave_details['paternal_leave_for_second_child']['opening'] !!}</td>
                                            <td>{!! $leave_details['paternal_leave_for_second_child']['applied'] !!}</td>
                                            <td>{!! $leave_details['paternal_leave_for_second_child']['balance'] !!}</td>
                                        </tr>
                                    @else
                                        <tr class="font-11">
                                            <td>Maternity Leave for 1st Child</td>
                                            <td>{!! $leave_details['maternity_leave_for_first_child']['opening'] !!}</td>
                                            <td>{!! $leave_details['maternity_leave_for_first_child']['applied'] !!}</td>
                                            <td>{!! $leave_details['maternity_leave_for_first_child']['balance'] !!}</td>
                                        </tr>
                                        <tr class="font-11">
                                            <td>Maternity Leave for 2nd Child</td>
                                            <td>{!! $leave_details['maternity_leave_for_second_child']['opening'] !!}</td>
                                            <td>{!! $leave_details['maternity_leave_for_second_child']['applied'] !!}</td>
                                            <td>{!! $leave_details['maternity_leave_for_second_child']['balance'] !!}</td>
                                        </tr>
                                    @endif
                                    <tr class="font-11">
                                        <td>Work From Home</td>
                                        <td>{!! $leave_details['applied_work_from_home']['opening'] !!}</td>
                                        <td>{!! $leave_details['applied_work_from_home']['applied'] !!}</td>
                                        <td>{!! $leave_details['applied_work_from_home']['balance'] !!}</td>
                                    </tr>
                                    <tr class="font-11">
                                        <td>Non Paid Leave</td>
                                        <td>{!! $leave_details['applied_non_paid_leave']['opening'] !!}</td>
                                        <td>{!! $leave_details['applied_non_paid_leave']['applied'] !!}</td>
                                        <td>{!! $leave_details['applied_non_paid_leave']['balance'] !!}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
@section('custom_page_script')
    <script type="text/javascript">
        $(document).ready(function(){

        });
    </script>

    <script>
        var app = new Vue({
            el:'#app',
            data:{
                selectedStatus: '',
                url: '{!! url("module/update_leave_status") !!}'
            },
            methods:{
                on_update_status: function(leaveId) {
                    console.log('Selected Status:', this.selectedStatus);
                    axios.get(this.url+'/'+leaveId+'/'+this.selectedStatus).then(response => {
                        window.location.reload();
                    }).catch(error => {
                        console.error('Error updating status:', error);
                    });
                }
            },
        });
    </script>
@endsection
