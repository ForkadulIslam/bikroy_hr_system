@extends('admin.layouts.form')
@section('custom_page_style')
    <style>
        .fix_min_height{
            min-height: 200px!important;
        }
    </style>
@endsection
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
                            <i class="material-icons btn btn-sm btn-warning">list</i> <span> &nbsp; Team leaders's leave Application</span>
                        </h2>
                    </div>
                    <div class="body">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="bg-teal">
                            <tr>
                                <th>#</th>
                                <th>Employee</th>
                                <th>Leave type</th>
                                <th>Reason</th>
                                <th>From date</th>
                                <th>To date</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Submitted At</th>
                                <th>Option</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($results as $i=>$result)
                                <tr class="font-12">
                                    <td>{!! ($i+1) !!}</td>
                                    <td>{!! $result->user->name !!}</td>
                                    <td>{!! $result->leave_type !!}</td>
                                    <td>{!! $result->reason !!}</td>
                                    <td>{!! $result->from_date !!}</td>
                                    <td>{!! $result->to_date !!}</td>
                                    <td>{!! $result->duration !!}</td>
                                    <td>
                                        @if($result->status == 'Approved')
                                            <span class="badge bg-green">{!! $result->status !!}</span>
                                            @elseif($result->status == 'Rejected')
                                            <span class="badge bg-red">{!! $result->status !!}</span>
                                            @elseif($result->status == 'Pending')
                                            <span class="badge bg-orange">{!! $result->status !!}</span>
                                        @endif
                                    </td>
                                    <td>{!! $result->created_at->toDateString() !!}</td>
                                    <td class="clearfix">
                                        {!! Form::select('leave_type', ['Approved'=>'Approved', 'Rejected'=>'Rejected'], $result->status, ['class'=>'', 'required'=>'true', 'v-model'=>'selectedStatus', '@change'=>'on_update_status('.$result->id.')','placeholder'=>'--Please Select--']) !!}
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
    <script>
        var app = new Vue({
            el:'#app',
            data:{
                selectedStatus: '',
                url: '{!! url("module/update_leave_status") !!}'
            },
            methods:{
                on_update_status: function(leaveId) {
                    console.log('Selected Status:', this.selectedStatus);
                    axios.get(this.url+'/'+leaveId+'/'+this.selectedStatus).then(response => {
                        window.location.reload();
                    }).catch(error => {
                        console.error('Error updating status:', error);
                    });
                }
            },
        });
    </script>
@endsection
