@extends('admin.layouts.form')
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <a href="{!! URL::to('module/banner') !!}" class="btn btn-sm btn-primary"> <i class="material-icons">list</i> ALL Banner</a>
            @if(Session::has('message'))
            <div class="alert bg-teal alert-dismissible m-t-20 animated fadeInDownBig" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                {!! Session::get('message') !!}
            </div>
            @endif
        </div>
        <!-- Color Pickers -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Update deals-ad
                            <small>You may put multiple link one after one</small>
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body" id="app">
                        <div class="row clearfix">
                            {!! Form::model($result,['url'=>URL::to('module/banner',$result->id),'class'=>'form','method'=>'put','files'=>'true']) !!}
                            <div class="col-xs-3">
                                <label for="">Market</label>
                                <div class="row clearfix">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="material-icons">import_export</i></span>
                                            {!! Form::select('market',['Bikroy'=>'Bikroy','Ikman'=>'Ikman','Tonaton'=>'Tonaton'],null,['class'=>'form-control selectpicker','v-model'=>'market']) !!}
                                        </div>
                                    </div>
                                </div>
                                <label for="">Title of this ad</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">person</i>
                                    </span>
                                    <div class="form-line">
                                        {!! Form::text('ad_title',$result->title,['class'=>'form-control','placeholder'=>'Title..']) !!}
                                    </div>
                                </div>

                                <label for="">Size</label>
                                <div class="row clearfix">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="material-icons">import_export</i></span>
                                            {!! Form::select('type',get_sizes(),null,['class'=>'form-control selectpicker','v-model'=>'type','@change'=>'create_preview_url']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div v-if="upload_banner_top_image">
                                    <label for="upload_top_image">Upload Top Image</label>
                                    <div class="row clearfix">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="material-icons">image</i></span>
                                                {!! Form::file('upload_top_image',['class'=>'form-control']) !!}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6" style="margin-bottom: 5px;">
                                        <a target="_blank" :href="prev_url" class="btn btn-warning btn-sm btn-block waves-effect waves-black"><i class="material-icons pull-left animated pulse infinite text-success" style="top:0px">details</i>View</a>
                                    </div>
                                    <div class="col-xs-6" style="margin-bottom: 5px;">
                                        <a href="#" class="btn btn-info btn-sm btn-block waves-effect waves-black" @click.prevent="generate_code()"><i class="material-icons pull-left animated pulse infinite text-info" style="top:0px">code</i> CODE</a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" value="UPDATE" class="btn btn-success btn-block btn-sm waves-effect waves-black">
                                </div>

                            </div>
                           <div class="col-xs-9">
                               <table class="table table-condensed table-bordered text-center" id="table">
                                   <thead>
                                   <tr>
                                       <td  style="width:200px">Link</td>
                                       <td style="width:200px">Title</td>
                                       <td style="width:183px;">Logo</td>
                                       <td style="width:100px">
                                           <a href="#" class="btn btn-success btn-xs" @click.prevent="addRow()"> <i class="material-icons">add</i></a>
                                       </td>
                                   </tr>
                                   </thead>
                                   <tbody>
                                   <tr v-for="(row, index) in table_data_arr" class="">
                                       <td style="width:200px">
                                           <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">link</i>
                                                </span>
                                               <div class="form-line">
                                                   <input style="" type="text" v-model="row.link" name="link[]" class="form-control" placeholder="Link" autofocus>
                                                   <input type="hidden" name="id[]" v-model="row.id" value="">
                                               </div>
                                           </div>
                                       </td>
                                       <td style="width:200px">
                                           <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">create</i>
                                                </span>
                                               <div class="form-line">
                                                   <input type="text" v-model="row.title" name="title[]" class="form-control" placeholder="Title">
                                               </div>
                                           </div>
                                           <img style="width: 183px;max-height: 120px;" :src="'{!! URL::asset('html_contents/') !!}/'+row.banner_id+'/'+row.image" alt="">
                                       </td>
                                       <td style="width:183px;">
                                           <div class="input-group">
                                               <div class="form-line">
                                                   <input style="width:183px" type="file" name="logo[]" id="">
                                               </div>
                                           </div>
                                       </td>
                                       <td style="width:50px">
                                           <a href="#" class="btn btn-success btn-xs" @click.prevent="addRow()"> <i class="material-icons">add</i></a>
                                           <a href="#" class="btn btn-xs btn-danger" @click.prevent="removeRow(row,index)"><i class="material-icons">remove</i></a>
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
                market: '{!! $result->market !!}',
                table_data_arr:{!! $result->contents !!},
                fix_prev_url: '{!! URL::to('module/banner',$result->id) !!}',
                prev_url : '{!! URL::to('module/banner?size=970x150',$result->id) !!}',
                type:'970x150',
                upload_banner_top_image:false,
            },
            methods:{
                addRow:function(){
                    this.table_data_arr.push({
                        id:'',
                        loading:false,
                        link:'#',
                        title:'',
                        image:'',
                        current_price:'',
                        discount:'',
                        discounted_price:''
                    });
                },
                removeRow:function(row,index){
                    if(row.id != ''){
                        var _this = this;
                        is_confirm(function(){
                            var url = '{!! URL::to('module/delete_banner_content') !!}/'+row.id;
                            var req = axios.get(url);
                            req.then(function(res){
                                swal_close('Data deleted');
                                _this.table_data_arr.splice(index,1);
                            });
                            req.catch(function(error){
                               swal_close('Server error found');
                            });

                        });
                    }else{
                        this.table_data_arr.splice(index,1);
                    }
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
                create_preview_url:function(){
                    //console.log(this.type);
                    this.prev_url = this.fix_prev_url+'?size='+this.type;
                    if(this.type === '970x250'){
                        this.upload_banner_top_image = true;
                    }else{
                        this.upload_banner_top_image = false;
                    }
                },
                generate_code:function(){
                    var _this= this;
                    var req = axios.get('{!! URL::to('create_html_file',$result->id) !!}'+'?size='+_this.type);
                    req.then(function(res){



                    });
                    req.catch(function(err){
                        console.log(err);
                        toast('There is a problem with server');
                    });

                    var split = _this.prev_url.split('size=');
                    var size = split[1].split('x');
                    var rand_version = Math.floor(Math.random() * Date.now()).toString(36);
                    console.log('{!! url("html_contents") !!}')
                    var template = '<iframe src="{!! url("html_contents") !!}/{!! $result->id !!}/'+_this.type+'.html?v='+rand_version+'" height="'+size[1]+'" width="'+size[0]+'" style="border:none" scrolling="no"></iframe>';
                    var $temp = $("<input>");
                    $("body").append($temp);
                    $temp.val(template).select();
                    document.execCommand("copy");
                    $temp.remove();
                    toast();

                }


            }
        });
    </script>
@endsection
