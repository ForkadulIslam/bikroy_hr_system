@extends('admin.layouts.form')
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            @if(Session::has('message'))
                <div class="alert bg-teal alert-dismissible m-t-20 animated fadeInDownBig" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    {!! Session::get('message') !!}
                </div>
            @endif
        </div>

        <!-- Striped Rows -->
        <div class="row clearfix" id="app">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header clearfix">
                        <h2 class="pull-left">
                            <i class="material-icons btn btn-sm btn-warning">list</i> <span>&nbsp; All Employee | <span class="small">{!! $department !!}</span></span>
                        </h2>
                        <div class="input-group pull-right" style="width:300px">
                            <span class="input-group-addon"><i class="material-icons">payments</i></span>
                            {!! Form::select('department',department_list(),null,['class'=>'form-control selectpicker','@change'=>'change_department', 'v-model'=>'department']) !!}
                        </div>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="bg-teal">
                            <tr>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Date Of Joining</th>
                                <th>CL</th>
                                <th>SL</th>
                                <th>EL</th>
                                <th>Others</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($results as $i=>$result)
                                <tr class="font-12">
                                    <td scope="row">{!! $result->attendance_id !!}</td>
                                    <td scope="row">
                                        <a target="_blank" href="{!! URL::to('module/show_team_leave_balance',$result->id) !!}">
                                            {!! $result->user->name !!}
                                        </a>
                                    </td>
                                    <td>{!! $result->designation !!}</td>
                                    <td>{!! $result->department !!}</td>
                                    <td>{!! $result->date_of_joining !!}</td>
                                    <td>{!! $result->getRemainingLeaveForCurrentYear()['casual_leave']['balance'] !!}</td>
                                    <td>{!! $result->getRemainingLeaveForCurrentYear()['sick_leave']['balance'] !!}</td>
                                    <td>{!! $result->getRemainingLeaveForCurrentYear()['earned_leave']['balance'] !!}</td>
                                    <td>
                                        @php
                                            if($result->gender == 'Male'){
                                                $total = $result->getRemainingLeaveForCurrentYear()['paternal_leave_for_first_child']['balance']+$result->getRemainingLeaveForCurrentYear()['paternal_leave_for_second_child']['balance'];
                                                echo $total;
                                            }else{
                                                $total = $result->getRemainingLeaveForCurrentYear()['maternity_leave_for_first_child']['balance'] + $result->getRemainingLeaveForCurrentYear()['maternity_leave_for_second_child']['balance'];
                                                echo $total;
                                            }
                                        @endphp
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Striped Rows -->
    </div>
@endsection
@section('custom_page_script')
    <script type="text/javascript">

        var app = new Vue({
            el:'#app',
            data:{
               department:'{!! $department !!}'
            },
            methods:{
                change_department:function(){
                    console.log(this.department)
                    let encoded = encodeURIComponent(this.department).replace(/%20/g,'+');
                    window.location.href='{!! url('module/leave_report?department=') !!}'+encoded;
                }

            },
        });




    </script>
@endsection
