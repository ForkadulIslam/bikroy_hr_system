<?php

namespace App\Http\Controllers;

use App\Models\Banner_content;
use App\Models\Blog_caurasol;
use App\Blog_caurasol_content;
use App\Campaign_creative;
use App\Classes\DirCompress;
use App\Models\Job_banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use KubAT\PhpSimple\HtmlDomParser;
use ZanySoft\Zip\Zip;

class JobsController extends Controller
{
    public function __construct()
    {
        $this->middleware('RedirectIfNotAuthenticate',['except'=>['show','clean_broken_ad']]);
    }

    public function index()
    {
        $results = Job_banner::orderBy('id','desc')->get();
        return view('admin.modules.banner.index',compact('results'));
    }
    public function create()
    {
        return view('admin.modules.banner.create');
    }
    public function store(Request $request)
    {
        $job = Job_banner::create([
            'title'=>$request->ad_title,
            'market'=>$request->market,
        ]);
        $input_arr = [];
        foreach($request->link as $i=>$link){
            $input_arr[$i]['banner_id'] = $job->id;
            $input_arr[$i]['link'] = trim($link);
            $input_arr[$i]['image'] = null;
            if(isset($request->file('logo')[$i])){
                $input_arr[$i]['image'] = $this->upload_logo($request->file('logo')[$i],$job->id);
            }
            $input_arr[$i]['title'] = $request->title[$i];
        }
        Banner_content::insert($input_arr);
        return redirect('module/banner')->with('message','Inserted successfully');
    }
    public function upload_logo($file,$job_id=false){
        File::makeDirectory('html_contents/'.$job_id, $mode = 0777, true, true);
        $extension = $file->getClientOriginalExtension();
        $rand = Str::random(40);
        $file_name = $rand.'.'.$extension;
        $file->move('html_contents/'.$job_id.'/',$file_name);
        return $file_name;
    }
    public function show(Request $request, $id)
    {
        $banner = Job_banner::with(['contents'])->find($id);
        $preview_layout = $request->size;
        return view('admin.modules.banner.preview_content.'.$preview_layout,compact('banner'));
    }
    public function edit($id)
    {
        $result = Job_banner::find($id);
        return view('admin.modules.banner.edit',compact('result'));
    }
    public function update(Request $request, $id)
    {
        //return $request->all();
        $banner = Job_banner::with('contents')->find($id);
        $banner->fill([
            'market'=>$request->market,
            'title'=>$request->ad_title,
            'image' => $request->file('upload_top_image') ? $this->upload_logo($request->file('upload_top_image'),$id) : $banner->image,
        ])->save();
        //return $banner;
        foreach($request->link as $i=>$link){
            if($request->id[$i] != null){
                $content = Banner_content::find($request->id[$i]);
                $image = $content->image;
                if(isset($request->file('logo')[$i])){
                    if(file_exists('html_contents/'.$id.'/'.$image)){
                        unlink('html_contents/'.$id.'/'.$image);
                    }
                    $image = $this->upload_logo($request->file('logo')[$i],$id);
                }
                $content->fill([
                    'link'=>trim($link),
                    'image'=>$image,
                    'title'=>$request->title[$i],
                ])->save();
            }else{
                //die('No id found.'. $i);
                $image = null;
                if(isset($request->file('logo')[$i])){
                    $image = $this->upload_logo($request->file('logo')[$i],$id);
                }
                Banner_content::create([
                    'banner_id' => $id,
                    'link'=>trim($link),
                    'image'=>$image,
                    'title'=>$request->title[$i],
                ]);
            }
        }
        //return $banner;
        $this->make_dir_and_file($id,get_sizes());

//        $zip = new DirCompress('html_contents/'.$id.'/', realpath('html_contents/'));
//        $zip->setZipFileName($id.".zip");
//        $zip->createZip();
//        $transfar = file_transfer('html_contents/'.$id.'.zip','jobs_scroller');

        return redirect()->back()->with(['message'=>'Updated successfully']);
    }
    public function destroy($id)
    {
        Job_banner::find($id)->delete();
        //delete_directory('html_contents/'.$id.'/');
    }

    public function scrap_data(Request $request){
        $url = $request->link;
        try {
            $dom = HtmlDomParser::file_get_html($url);
        }
        catch (\Exception $e) {
            return array();
            //return $e->getMessage();
        }
        $container = $dom->find('div.app-content > div')[0];
        $title = '';$current_price=0;$discount=0;$arr = [];$img='';$discounted_price=0;
        if(isset($container->find('nav')[0]->nextSibling()->find('div')[0])){
            $panel_block =  $container->find('nav')[0]->nextSibling()->find('div')[0];
            if(isset($panel_block->find('span.amount')[0])){
                $price =  $panel_block->find('span.amount')[0]->plaintext;
                $current_price = (int)str_replace(',', '', $price);
            }
            if(isset($panel_block->find('h1[itemprop="name"]')[0])){
                $title = $panel_block->find('h1[itemprop="name"]')[0]->plaintext;
            }
            if(isset($panel_block->find('a.gallery-nav-item > img')[0])){
                $str = $panel_block->find('a.gallery-nav-item > img')[2]->getAttribute('data-srcset');
                $explode = explode(',',$str);
                //return $explode;
                $img = explode(' ',trim($explode[1]))[0];
                $fitted_img = '';
                $img_path_arrays = explode('/',$img);
                foreach($img_path_arrays as $i=>$im){
                    if($i < count($img_path_arrays)-1){
                        $fitted_img .= $im.'/';
                    }else{
                        $fitted_img.='fitted.jpg';
                    }
                }
                $img = $fitted_img;
            }
            if(count(explode('%',$title)) > 1){
                $str =  explode('%',$title)[0];
                $dis_arr =explode(' ',$str);
                //return end($dis_arr);
                $discount = (int)end($dis_arr);
            }
            if($discount>0){
                $discounted_price = ($current_price*100)/(100-$discount);
            }
            $arr = [
                'title'=>explode('-',$title)[0],
                'current_price'=>$current_price,
                'discount'=>$discount,
                'img'=>$img,
                'discounted_price'=>round($discounted_price),
            ];
        }
        return $arr;
    }
    public function delete_banner_content($id){
        $content = Banner_content::find($id);
        $campaign_id = $content->banner_id;
        $content->delete();
        $this->make_dir_and_file($campaign_id,get_sizes());
    }
    public function clean_broken_ad(){
        $links =  Jobscroller_content::select('link','id')->get();
        $campaign_ids = [];
        foreach($links as $link){
            try {
                $dom = HtmlDomParser::file_get_html($link->link);
            }
            catch (\Exception $e) {
                $deals_content = Jobscroller_content::find($link->id);
                $campaign_ids[] = $deals_content->deal_id;
                $deals_content->delete();
            }
        }
        foreach($campaign_ids as $campaign_id){
            $this->make_dir_and_file($campaign_id,get_sizes());
        }
        $serps =  Blog_caurasol::get();
        //return $serps;
        foreach($serps as $serp){
            $dom = HtmlDomParser::file_get_html($serp->link);
            $container = $dom->find('div.serp-items',0);
            $item_array = [];
            $blog_caurasol = Blog_caurasol::find($serp->id);
            $blog_caurasol->contents()->delete();
            foreach($container->find('.ui-item') as $i=>$item){
                if($i<5){
                    if($item->find('img',0)){
                        $image = generate_fitted_image($item->find('img',0)->getAttribute('data-srcset'));
                        $item_array['image']        = generate_custom_image_path($image,'100/100');
                    }else{
                        $item_array['image'] = null;
                    }
                    $item_array['title']        = $item->find('.item-title',0)->plaintext;
                    $item_array['job_provider'] = ($item->find('.item-meta',0)) ? $item->find('.item-meta',0)->plaintext : null;
                    $item_array['is_member']    = ($item->find('.is-member')) ? true: false;
                    $item_array['location']     = ($item->find('.item-area',0)) ? $item->find('.item-area',0)->plaintext: null;
                    $item_array['item_cat']     = ($item->find('.item-cat',0)) ? $item->find('.item-cat',0)->plaintext: null;
                    $item_array['price']        = ($item->find('.item-info',0)) ? $item->find('.item-info',0)->plaintext: null;
                    $item_array['link']         = 'https://bikroy.com'.$item->find('.item-title',0)->getAttribute('href').'?utm_source=bikroy_blog&utm_medium=blog_banners&utm_campaign=blog_post&utm_content=300x200';
                    $blog_caurasol->contents()->save(new Blog_caurasol_content($item_array));
                }
            }
        }
    }

    public function create_html_file(Request $request,$id){
        $size = $request->size;
        $this->make_dir_and_file($id,$size);
        return 1;
    }

    public function make_dir_and_file($id,$preview_layout){
        $process_transfer = true;
        $banner = Job_banner::with(['contents'])->find($id);
        File::makeDirectory('html_contents/'.$id, $mode = 0777, true, true);
        if(is_array($preview_layout)){
            foreach($preview_layout as $key=>$value){
                File::put('html_contents/'.$id.'/'.$key.'.html',view('admin.modules.banner.preview_content.'.$key,compact('banner','process_transfer')));
            }
        }else{
            File::put('html_contents/'.$id.'/'.$preview_layout.'.html',view('admin.modules.banner.preview_content.'.$preview_layout,compact('banner','process_transfer')));
        }
    }

    public function scrap_stats(){
        $url = 'https://bikroy.com/en/ads/bangladesh/jobs';
        try {
            $dom = HtmlDomParser::str_get_html( $url );
        }
        catch (\Exception $e) {
            //return array();
            return $e->getMessage();
        }
        $container = $dom->find('.ads-count-text--1UYy_');

        dd($container);
    }

}
