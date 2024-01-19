@extends('admin.layouts.form')
@section('content')
    <div class="container-fluid">
        <div class="block-header">

        </div>

        <!-- Striped Rows -->
        <div class="row clearfix" id="app">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header clearfix">
                        <h2 class="pull-left">
                            <i class="material-icons btn btn-sm btn-warning">list</i> <span>&nbsp; {!! $user->name !!} | <span class="small">{!! $user->employee->attendance_id !!}</span></span>
                        </h2>
                        <div class="input-group pull-right clearfix" style="width:300px">
                            <span class="input-group-addon"><i class="material-icons">list</i></span>
                            {!! Form::select('month',get_month_list(),null,['class'=>'form-control selectpicker','@change'=>'on_change', 'v-model'=>'month']) !!}
                        </div>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="bg-teal">
                            <tr>
                                <th>Attendance ID</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user->employee->attendance as $i=>$result)
                                <tr class="font-12">
                                    <td scope="row">{!! $result->attendance_id !!}</td>
                                    <td scope="row">
                                        {!! $result->attendance_date !!}
                                    </td>
                                    <td>{!! $result->attendance_time !!}</td>
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
                user_id: '{!! $user->id !!}',
                month: '{!! $month !!}'
            },
            methods:{

                on_change:function(){
                    let encoded = '?month='+encodeURIComponent(this.month).replace(/%20/g,'+')
                    window.location.href='{!! url('module/attendance_log_by_user') !!}/'+this.user_id+encoded;
                }

            },
        });




    </script>
@endsection
