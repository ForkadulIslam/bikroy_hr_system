﻿@extends('admin.layouts.form')
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
                        <h2 class="pull-left"><i class="material-icons btn btn-sm btn-warning">list</i> <span>&nbsp; Create new Employee</h2>
                        <a href="{!! URL::to('module/employee') !!}" class="pull-right">Employee List</a>
                    </div>
                    <div class="body" id="app">
                        {!! Form::open(['url'=>URL::to('module/employee'),'class'=>'form','files'=>'true',]) !!}
                        <div class="row clearfix">
                            <div class="col-xs-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4>Basic info</h4>
                                    </div>
                                    <div class="panel-body">
                                        <label for="">Attendance ID</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">fingerprint</i>
                                            </span>
                                            <div class="form-line">
                                                <input type="text" name="attendance_id" class="form-control" placeholder="ID.." autofocus required>
                                            </div>
                                        </div>

                                        <label for="">Full name</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">person</i>
                                            </span>
                                            <div class="form-line">
                                                <input type="text" name="full_name" class="form-control date" placeholder="Full name" required>
                                            </div>
                                        </div>

                                        <label for="">Fathers name</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">person</i>
                                            </span>
                                            <div class="form-line">
                                                <input type="text" name="fathers_name" class="form-control date" placeholder="Fathers name" required>
                                            </div>
                                        </div>

                                        <label for="">Email address</label>
                                        <div v-if="!emailAvailable" class="">
                                            <label for="" class="text-danger">This email is not accepted</label>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">mail</i>
                                            </span>
                                            <div class="form-line">
                                                <input type="text" v-model="email" @blur="checkEmailAvailability" name="email" class="form-control" placeholder="Email" required>
                                            </div>
                                        </div>

                                        <label for="">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">mail</i>
                                            </span>
                                            <div class="form-line">
                                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                                            </div>
                                        </div>

                                        <label for="">Mobile no</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">call</i>
                                            </span>
                                            <div class="form-line">
                                                <input type="text" name="phone_no" class="form-control date" placeholder="Mobile NO" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4>Additional info</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <label for="">Date of birth</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">calendar_month</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="date_of_birth" class="form-control datepicker" placeholder="Birth date.." required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="">Date of Joining</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">calendar_month</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="date_of_joining" class="form-control datepicker" placeholder="Joining Date" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-6">
                                                <label for="">Religion</label>
                                                <div class="row clearfix">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="material-icons">mosque</i></span>
                                                            {!! Form::select('religion',['Muslim'=>'Muslim','Hindu'=>'Hindu', 'Others'=>'Others'],null,['class'=>'form-control selectpicker']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="">End of contract date</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">calendar_month</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="end_of_contract_date" class="form-control datepicker" placeholder="End of contract date" autofocus>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-6">
                                                <label for="">Gender</label>
                                                <div class="row clearfix">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="material-icons">man</i></span>
                                                            {!! Form::select('gender',['Male'=>'Male','Female'=>'Female', 'Others'=>'Others'],null,['class'=>'form-control selectpicker']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="">Marital Status</label>
                                                <div class="row clearfix">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="material-icons">female</i></span>
                                                            {!! Form::select('marital_status',['Married'=>'Married','Single'=>'Single', 'Others'=>'Others'],null,['class'=>'form-control selectpicker']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-6">
                                                <label for="">Category</label>
                                                <div class="row clearfix">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="material-icons">import_export</i></span>
                                                            {!! Form::select('category',['Permanent'=>'Permanent','Contractual'=>'Contractual', 'Others'=>'Others'],null,['class'=>'form-control selectpicker']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="">Payment Mode</label>
                                                <div class="row clearfix">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="material-icons">payments</i></span>
                                                            {!! Form::select('payment_mode',['Cash'=>'Cash','Cheque'=>'Cheque', 'Bank transfer'=>'Bang transfer'],null,['class'=>'form-control selectpicker']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <label for="">TIN no</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">verified_user</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="tin_no" class="form-control date" placeholder="TIN no">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="">Vendor Code</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">code</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="vendor_code" class="form-control date" placeholder="Vendor Code">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-6">
                                                <label for="">Department</label>
                                                <div class="row clearfix">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="material-icons">payments</i></span>
                                                            {!! Form::select('department',department_list(),null,['class'=>'form-control selectpicker']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="">Designation</label>
                                                <div class="row clearfix">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="material-icons">payments</i></span>
                                                            {!! Form::select('designation',designation_list(),null,['class'=>'form-control selectpicker']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-8 col-xs-offset-4">
                                <div class="form-group">
                                    <input type="submit" name="submit" value="SAVE" class="btn btn-success btn-sm btn-block">
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
