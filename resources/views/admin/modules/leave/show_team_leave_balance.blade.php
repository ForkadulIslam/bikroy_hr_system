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
                    <div class="header">
                        <h2 class="">
                            <i class="material-icons btn btn-sm btn-warning">list</i> <span> &nbsp; Employee ID: <span class="font-bold">{!! $employee->attendance_id !!}</span></span>
                        </h2>
                    </div>
                    <div class="body" id="app">

                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4>{!! $employee->user->name !!}</h4>
                                        <p>{!! $employee->designation . ' | '. $employee->department. ' | '. $employee->user->email !!}</p>
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
                },

            },

        });




    </script>
@endsection
