@extends('admin.layouts.form')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <!-- Add any alerts or messages here -->
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header clearfix">
                        <h2 class="pull-left">
                            <i class="material-icons btn btn-sm btn-warning">create</i> <span> &nbsp; Edit Holiday</span>
                        </h2>
                        <a href="{!! URL::to('module/holiday') !!}" class="pull-right">Back to List</a>
                    </div>
                    <div class="body">
                        {!! Form::model($holiday, ['url'=>URL::to('module/holiday/'.$holiday->id),'class'=>'form','files'=>'true','method'=>'PATCH']) !!}
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <label for="holiday_date">Holiday Date</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="material-icons">calendar_today</i></span>
                                    {!! Form::text('holiday_date', null, ['class'=>'form-control datepicker', 'placeholder'=>'Select Holiday Date', 'required'=>'true']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <label for="holiday_name">Holiday Name</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="material-icons">label</i></span>
                                    {!! Form::text('holiday_name', null, ['class'=>'form-control', 'placeholder'=>'Enter Holiday Name', 'required'=>'required']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    {!! Form::submit('Update', ['class'=>'btn btn-success btn-sm']) !!}
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_page_script')
    <script type="text/javascript">

        $(document).ready(function(){
            $('.datepicker').bootstrapMaterialDatePicker({
                format: 'Y-MM-DD',
                clearButton: true,
                weekStart: 1,
                time: false
            });

        })

        var app = new Vue({
            el:'#app',
            data:{

            },
            methods:{


            },

        });




    </script>
@endsection
