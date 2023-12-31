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
                            <i class="material-icons btn btn-sm btn-warning">list</i> <span>&nbsp; All Team leaders</span>
                        </h2>
                        <a href="{!! URL::to('module/create_team_leader') !!}" class="pull-right">+ Create New</a>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="bg-teal">
                                <tr>
                                    <th>Team leader</th>
                                    <th>Employee ID</th>
                                    <th>Designation</th>
                                    <th>Department</th>
                                    <th>Joining Date</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($results as $i=>$result)
                            <tr class="font-12">
                                <td>{!! $result->user->name !!}</td>
                                <td>{!! $result->user->employee->attendance_id !!}</td>
                                <td>{!! $result->user->employee->designation !!}</td>
                                <td>{!! $result->user->employee->department !!}</td>
                                <td>{!! $result->user->employee->date_of_joining !!}</td>
                                <td>
                                    <a data-toggle="tooltip" data-title="Edit & Preview" class="btn btn-xs btn-danger" href="{!! URL::to('module/delete_team_leader',$result->id) !!}"><i class="material-icons">delete</i></a>
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

@endsection
