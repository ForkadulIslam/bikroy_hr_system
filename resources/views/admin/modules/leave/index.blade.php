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
                            <i class="material-icons btn btn-sm btn-warning">list</i> <span> &nbsp; My Leave Application</span>
                        </h2>
                        <a href="{!! URL::to('module/leave/create') !!}" class="pull-right">+ Create New</a>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="bg-teal">
                            <tr>
                                <th>#</th>
                                <th>Leave type</th>
                                <th>Reason</th>
                                <th>From date</th>
                                <th>To date</th>
                                <th>Duration</th>
                                <th>Submitted At</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($results as $i=>$result)
                            <tr class="font-12">
                                <td>{!! ($i+1) !!}</td>
                                <td>{!! $result->leave_type !!}</td>
                                <td>{!! $result->reason !!}</td>
                                <td>{!! $result->from_date !!}</td>
                                <td>{!! $result->to_date !!}</td>
                                <td>{!! $result->duration !!}</td>
                                <td>{!! $result->created_at->toDateString() !!}</td>
                                <td>
                                    @if($result->status == 'Pending')
                                        <a data-toggle="tooltip" data-title="Edit & Preview" class="btn btn-xs btn-warning" href="{!! URL::to('module/leave/'.$result->id,'edit') !!}"><i class="material-icons">edit</i></a>
                                        <a data-toggle="tooltip" data-title="Delete" class="btn btn-xs btn-danger" href="{!! URL::to('module/delete_leave',$result->id) !!}"><i class="material-icons">remove</i></a>
                                    @else
                                        <span class="badge {!! $result->status == "Approved" ? "bg-green" : 'bg-red' !!}">{!! $result->status !!}</span>
                                    @endif
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
