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
                            <i class="material-icons btn btn-sm btn-warning">list</i> <span> &nbsp; Holiday dates</span>
                        </h2>
                        <a href="{!! URL::to('module/holiday/create') !!}" class="pull-right">+ Create New</a>
                    </div>
                    <div class="body table-responsive">
                        <p>TOTAL : {!! $results->total() !!}</p>
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="bg-teal">
                            <tr>
                                <th>Name</th>
                                <th>Day</th>
                                <th>Option</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($results as $i=>$result)
                            <tr class="font-12">
                                <td>{!! $result->holiday_name !!}</td>
                                <td>{!! $result->holiday_date !!}</td>
                                <td>
                                    <a data-toggle="tooltip" data-title="Edit & Preview" class="btn btn-xs btn-warning" href="{!! URL::to('module/holiday/'.$result->id,'edit') !!}"><i class="material-icons">edit</i></a>
                                    <a data-toggle="tooltip" data-title="Delete" class="btn btn-xs btn-danger delete_with_swal" href="{!! URL::to('module/delete_holiday',$result->id) !!}"><i class="material-icons">remove</i></a>
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
