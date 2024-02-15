@extends('admin.layouts.form')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            @if(session('message'))
                <div class="alert bg-teal alert-dismissible m-t-20 animated fadeInDownBig" role="alert">
                    {{ session('message') }}
                </div>
            @endif
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header clearfix">
                        <h2 class="pull-left">
                            <i class="material-icons btn btn-sm btn-warning">create</i> <span> &nbsp; Change password</span>
                        </h2>
                    </div>
                    <div class="body">
                        {!! Form::open(['url'=>URL::to('module/save_change_password'),'class'=>'form']) !!}
                        <div class="row clearfix">
                            <div class="col-xs-6">
                                <label for="holiday_date">New password</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="material-icons">lock</i></span>
                                    <div class="form-line">
                                        <input class="form-control" type="password" placeholder="New password..." name="new_password" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    {!! Form::submit('UPDATE', ['class'=>'btn btn-success']) !!}
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






    </script>
@endsection
