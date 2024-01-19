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
                            <i class="material-icons btn btn-sm btn-warning">list</i> <span>&nbsp; All Employee</span>
                        </h2>
                        <a href="{!! URL::to('module/employee/create') !!}" class="pull-right">+ Create New</a>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="bg-teal">
                            <tr>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Joining Date</th>
                                <th>Option</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($results as $i=>$result)
                            <tr class="font-12">
                                <th scope="row">{!! $result->attendance_id !!}</th>
                                <td>
                                    <a data-toggle="tooltip" data-title="Edit & Preview" href="{!! URL::to('module/employee/'.$result->id,'edit') !!}">{!! $result->user->name !!}</a>
                                </td>
                                <td>{!! $result->user->email !!}</td>
                                <td>{!! $result->designation !!}</td>
                                <td>{!! $result->department !!}</td>
                                <td>{!! $result->date_of_joining !!}</td>
                                <td>
                                    <a data-toggle="tooltip" data-title="Edit & Preview" class="btn btn-xs btn-warning" href="{!! URL::to('module/employee/'.$result->id,'edit') !!}"><i class="material-icons">edit</i></a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $results->links() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Striped Rows -->
    </div>
@endsection
@section('custom_page_script')

@endsection
