@extends('admin.layouts.form')
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <!-- Color Pickers -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header clearfix">
                        <h2 class="pull-left">Create new leave application</h2>
                        <a href="{!! URL::to('module/leave') !!}" class="pull-right">My all leave</a>
                    </div>
                    <div class="body" id="app">
                        {!! Form::open(['url'=>URL::to('module/leave'),'class'=>'form','files'=>'true',]) !!}
                        <div class="row clearfix">
                            <div class="col-xs-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4>Leave Application Form</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-12">

                                                <label for="">Leave type</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="material-icons">time_to_leave</i></span>
                                                    {!! Form::select('leave_type',leave_type_array(),null,['class'=>'form-control selectpicker', 'required'=>'true']) !!}
                                                </div>

                                                <label for="">From Date</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">calendar_month</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="from_date" class="form-control datepicker" placeholder="Birth date.." required>
                                                    </div>
                                                </div>

                                                <label for="">To Date</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">calendar_month</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="to_date" class="form-control datepicker" placeholder="Birth date.." required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <input type="checkbox" name="is_half_day" v-model="isHalfDay" id="is_half_day" value="yes" class="filled-in chk-col-green" checked="">
                                                        <label for="is_half_day">Half Day</label>
                                                    </div>
                                                </div>

                                                <div class="row" v-if="isHalfDay">
                                                    <div class="col-xs-4">
                                                        <input type="radio" name="half_day_type" value="1st half" id="firstHalf" class="filled-in chk-col-green" required>
                                                        <label for="firstHalf">First Half</label>
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <input type="radio" name="half_day_type" value="2nd half" id="secondHalf" class="filled-in chk-col-green" required>
                                                        <label for="secondHalf">Second Half</label>
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <input type="radio" name="half_day_type" value="Others" id="others" class="filled-in chk-col-green" required>
                                                        <label for="others">Others</label>
                                                    </div>
                                                </div>


                                                <label for="">Reason</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">short_text</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="reason" class="form-control date" placeholder="Reason" required>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <input type="submit" name="submit" value="SUBMIT" class="btn btn-success btn-sm btn-block">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4>My Leave balance</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <table class="table table-bordered table-hovered table-condenced">
                                                    <thead>
                                                    <tr>
                                                        <th>Type</th>
                                                        <th>Opening</th>
                                                        <th>Available</th>
                                                        <th>Balance</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr class="font-11">
                                                        <td>{!! $my_leave_balance['earned_leave'] !!}</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Color Pickers -->

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
                email: '', // Add an email property to store the email value
                emailAvailable: true,
                isHalfDay:false,
            },
            methods:{
                checkEmailAvailability: function () {
                    this.emailAvailable = true;
                    // Make an AJAX request to check email availability
                    axios.post('{{ route("check.email.availability") }}', {
                        email: this.email,
                    }).then(response => {
                        console.log(response.data);
                        this.emailAvailable = response.data.available;
                    }).catch(error => {
                        this.emailAvailable = false;
                        this.email = '';
                    });

                },
                submitForm: async function (){
                    // Check email availability before submitting the form

                    await this.checkEmailAvailability();
                    // If email is not available, prevent form submission
                    if (!this.emailAvailable) {
                        return false;
                    }else{
                        console.log('Should go')
                        return true;
                    }
                    // Otherwise, proceed with form submission
                    // You may want to show a loading spinner or disable the submit button during the AJAX request
                },

            },
            // watch: {
            //     // Watch for changes in the email property
            //     email: function () {
            //         // Call the checkEmailAvailability method on email change
            //         this.checkEmailAvailability();
            //     },
            // },
        });




    </script>
@endsection
