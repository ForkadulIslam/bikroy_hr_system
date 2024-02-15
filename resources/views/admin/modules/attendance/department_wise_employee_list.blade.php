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
                        <div class="input-group pull-right clearfix" style="width:600px">
                            <span class="input-group-addon"><i class="material-icons">list</i></span>
                            {!! Form::select('month',get_month_list(),null,['class'=>'form-control selectpicker','@change'=>'change_month', 'v-model'=>'month']) !!}
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
                                <th>Total Late Minutes</th>
                                <th>Total Absent</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($results as $i=>$result)
                                <tr class="font-12">
                                    <td scope="row">{!! $result->attendance_id !!}</td>
                                    <td scope="row">
                                        <a target="_blank" href="{!! URL::to('module/attendance_log_by_user',$result->user_id) !!}">
                                            {!! $result->user->name !!}
                                        </a>
                                    </td>
                                    <td>{!! $result->designation !!}</td>
                                    <td>{!! $result->department !!}</td>
                                    <td>{!! $result->date_of_joining !!}</td>
                                    <td>
                                        @php
                                            $total_late_min = 0;
                                            foreach($result->attendance_log_in_out as $att_log){
                                                //print_r($att_log);
                                                $total_late_min += $att_log['late_min'];
                                            }
                                            echo $total_late_min;
                                        @endphp
                                    </td>
                                    <td>
                                        {!! count($result->absent_days) !!}
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
                department:'{!! $department !!}',
                month: '{!! $month !!}'
            },
            methods:{
                change_month:function(){
                    let encoded = '?department='+encodeURIComponent(this.department).replace(/%20/g,'+');
                    encoded += '&month='+encodeURIComponent(this.month).replace(/%20/g,'+')
                    window.location.href='{!! url('module/attendance') !!}'+encoded;
                },
                change_department:function(){
                    let encoded = '?department='+encodeURIComponent(this.department).replace(/%20/g,'+');
                    encoded += '&month='+encodeURIComponent(this.month).replace(/%20/g,'+')
                    window.location.href='{!! url('module/attendance') !!}'+encoded;
                }

            },
        });




    </script>
@endsection
