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
                <div class="card clearfix">
                    <div class="header clearfix">
                        <h2 class="pull-left">
                            <i class="material-icons btn btn-sm btn-warning">list</i> <span> &nbsp;Create leave application </span>
                        </h2>
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
                                                    {!! Form::select('leave_type',$leave_types,null,['class'=>'form-control selectpicker', 'required'=>'true']) !!}
                                                </div>

                                                <label for="">From Date</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">calendar_month</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input id="from_date" type="text" name="from_date" class="form-control datepicker" placeholder="From date.." required>
                                                    </div>
                                                </div>

                                                <label for="">To Date</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">calendar_month</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input id="to_date" type="text" name="to_date" class="form-control datepicker" placeholder="To date.." required>
                                                    </div>
                                                </div>

                                                <div id="half_day_container">
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
                                                </div>

                                                <label for="">Reason</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">short_text</i>
                                                    </span>
                                                    <div class="form-line">
                                                        {!! Form::textarea('reason',null,['class'=>'form-control', 'rows'=>'2', 'required'=>'required']) !!}
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
        $('#half_day_container').hide();
        function isOneDayDuration(from_date, to_date) {
            const fromDate = new Date(from_date);
            const toDate = new Date(to_date);
            const durationInMilliseconds = toDate - fromDate;
            const durationInDays = durationInMilliseconds / (24 * 60 * 60 * 1000);
            console.log(durationInDays)
            if(durationInDays == 0){
                $('#half_day_container').show()
            }else{
                $('#half_day_container').hide();
            }
        }
        $(document).ready(function(){
            $('.datepicker').bootstrapMaterialDatePicker({
                format: 'Y-MM-DD',
                clearButton: true,
                weekStart: 1,
                time: false
            });

            $('#from_date').change(function(){
                var from_date = $(this).val();
                var to_date = $('#to_date').val();
                isOneDayDuration(from_date, to_date)
            })

            $('#to_date').change(function(){
                var from_date = $('#from_date').val();
                var to_date = $(this).val();
                isOneDayDuration(from_date, to_date)
            })





        })

        var app = new Vue({
            el:'#app',
            data:{
                email: '',
                emailAvailable: true,
                isHalfDay:false,
                from_date:null,
                to_date: null
            },
            computed: {

            },
            methods:{

                checkEmailAvailability: function () {
                    this.emailAvailable = true;
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
                    await this.checkEmailAvailability();
                    if (!this.emailAvailable) {
                        return false;
                    }else{
                        console.log('Should go')
                        return true;
                    }
                },

            },
        });




    </script>
@endsection
