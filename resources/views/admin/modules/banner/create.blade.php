@extends('admin.layouts.form')
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <a href="{!! URL::to('module/banner') !!}" class="btn btn-sm btn-primary"> <i class="material-icons">list</i> ALL banner ad</a>
        </div>
        <!-- Color Pickers -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Create new banner ad
                            <small>You may put multiple link one after one</small>
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body" id="app">
                        <div class="row clearfix">
                            {!! Form::open(['url'=>URL::to('module/banner'),'class'=>'form','files'=>'true']) !!}
                            <div class="col-xs-4">
                                <label for="">Market</label>
                                <div class="row clearfix">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="material-icons">import_export</i></span>
                                            {!! Form::select('market',['Bikroy'=>'Bikroy','Ikman'=>'Ikman'],null,['class'=>'form-control selectpicker']) !!}
                                        </div>
                                    </div>
                                </div>
                                <label for="">Title</label>
                                <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">person</i>
                                                </span>
                                    <div class="form-line">
                                        <input type="text" name="ad_title" class="form-control date" placeholder="Title.." autofocus>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="submit" name="submit" value="SAVE" class="btn btn-success btn-sm btn-block">
                                </div>

                            </div>
                           <div class="col-xs-8">
                               <table class="table table-condensed table-bordered text-center" id="table">
                                   <thead>
                                   <tr>
                                       <td  style="width:300px">Link</td>
                                       <td>Title</td>
                                       <td>Company Logo</td>
                                       <td>
                                           <a href="#" class="btn btn-success btn-xs" @click.prevent="addRow()"> <i class="material-icons">add</i></a>
                                       </td>
                                   </tr>
                                   </thead>
                                   <tbody>
                                   <tr v-for="(row, index) in table_data_arr" class="">
                                       <td style="width:100px">
                                           <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">link</i>
                                                </span>
                                               <div class="form-line">
                                                   <input style="" type="text" v-model="row.link" name="link[]" class="form-control" placeholder="Link" autofocus>
                                               </div>
                                           </div>
                                       </td>
                                       <td>
                                           <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">create</i>
                                                </span>
                                               <div class="form-line">
                                                   <input type="text" v-model="row.title" name="title[]" class="form-control" placeholder="Title">
                                               </div>
                                           </div>
                                       </td>
                                       <td>
                                           <div class="input-group">
                                               <div class="form-line">
                                                   <input style="width:90px;" type="file" name="logo[]" id="">
                                               </div>
                                           </div>
                                       </td>
                                       <td style="width:100px">
                                           <a href="#" class="btn btn-xs btn-danger" @click.prevent="removeRow(index)"><i class="material-icons">remove</i></a>
                                       </td>
                                   </tr>
                                   </tbody>
                               </table>

                           </div>
                            {!! Form::close() !!}
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

        var app = new Vue({
            el:'#app',
            data:{
                table_data_arr:[
                    {
                        loading:false,
                        link:'#',
                        title:'',
                        image:'',
                        current_price:'',
                        discount:'',
                        discounted_price:''
                    }
                ]
            },
            methods:{
                addRow:function(){
                    this.table_data_arr.push({
                        loading:false,
                        link:'#',
                        title:'',
                        image:'',
                        current_price:'',
                        discount:'',
                        discounted_price:''
                    });
                    //$('#table tbody tr:first').addClass('animated bounceIn')
                },
                removeRow:function(index){
                    this.table_data_arr.splice(index,1);
                },
                change_link:function (row, index) {
                    row.loading=true;
                    row.title = '';
                    row.image = '';
                    row.current_price = '';
                    row.discount = '';
                    row.discounted_price = '';
                    var url = '{!! URL::to('module/scrap_data_for_deals_ad') !!}?link='+row.link;
                    var req = axios.get(url);
                    req.then(function(res){
                        var res = res.data;
                        row.loading = false;
                        row.title = res.title;
                        row.image = res.img;
                        row.current_price = res.current_price;
                        row.discount = res.discount;
                        row.discounted_price = Math.ceil(res.discounted_price/10)*10
                    });
                    req.catch(function(error){
                        row.loading = false;
                    });
                },

            }
        });


    </script>
@endsection
