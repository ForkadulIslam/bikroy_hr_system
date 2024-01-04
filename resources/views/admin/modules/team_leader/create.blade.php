@extends('admin.layouts.form')
@section('custom_page_style')
    <style>
        .bootstrap-autocomplete.dropdown-menu{
            top:71px!important;
        }
    </style>
@endsection
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
                        <h2 class="pull-left">
                            <i class="material-icons btn btn-sm btn-warning">list</i> <span>&nbsp; Create new team leader</span>
                        </h2>
                        <a href="{!! URL::to('module/manage_team_leader') !!}" class="pull-right">All team leader</a>
                    </div>
                    <div class="body" id="app">
                        {!! Form::open(['url'=>URL::to('module/save_team_leader'),'class'=>'form','files'=>'true',]) !!}
                        <div class="row clearfix">
                            <div class="col-xs-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4>Add team leader</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <label for="">Department</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="material-icons">home</i></span>
                                                    {!! Form::select('department',department_list(),null,['class'=>'form-control selectpicker', 'required'=>'true','v-model'=>'department','@change'=>'change_department']) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <label for="">Team Leader</label>
                                                <div class="input-group">
                                                    <span id="" class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line autoCompleter" style="margin-bottom: 0px;">
                                                        <input type="hidden" name="user_id" v-model="user_id">
                                                        <input class="form-control" ref="teamLeaderName" v-model="user_name" placeholder="Name" autocomplete="off" required="required" name="team_leader_name" type="text" @keyup="get_team_leader_name">
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
    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.5/dist/latest/bootstrap-autocomplete.min.js"></script>

    <script type="text/javascript">

        let app = new Vue({
            el:'#app',
            data:{
                user_id:0,
                department:'{!! collect(department_list())->first() !!}',
                user_name: null,
            },

            methods:{
                change_department: function () {
                    this.user_id = null;
                    this.user_name = null;
                },
                get_team_leader_name: function () {
                    let elem = this.$refs.teamLeaderName;
                    let _this = this;
                    $(elem).autoComplete({
                        resolver:'custom',
                        events: {
                            search: function (qry, callback) {
                                let url = '{!! url('module/team_leader_name_suggestion') !!}?department='+encodeURIComponent(_this.department)+'&q='+$(elem).val();
                                axios.get(url).then(function (res) {
                                    callback(res.data)
                                });
                            }
                        },
                        minLength:1,
                        preventEnter:true
                    }).on('autocomplete.select', function (evt, item) {
                        console.log(item);
                        _this.user_id = item.id;
                        _this.user_name = item.name;
                        return false;
                    });
                }
            }
        });

    </script>
@endsection
