<?php

namespace App\Http\Controllers;

use App\Blog_category;
use App\Blog_caurasol;
use App\Blog_caurasol_content;
use Illuminate\Http\Request;
use Sunra\PhpSimple\HtmlDomParser;

class BlogCaurasolCrud extends Controller
{
    public function __construct()
    {
        $this->middleware('RedirectIfNotAuthenticate',['except'=>'show']);
    }

    public function index()
    {
        $results = Blog_caurasol::latest()->paginate(20);
        return view('admin.modules.blog_caurasol.index',compact('results'));
    }

    public function create()
    {
        $blog_categories = Blog_category::pluck('name','id');
        return view('admin.modules.blog_caurasol.create',compact('blog_categories'));
    }

    public function store(Request $request)
    {
        $blog_caurasol = Blog_caurasol::create($request->only(['title','link','blog_category_id']));
        foreach ($request->ad_content as $content){
            $content['link']  = $content['link'].'?utm_source=bikroy_blog&utm_medium=blog_banners&utm_campaign=blog_post&utm_content=300x200';
            //return strlen($content['link']);
            $blog_caurasol->contents()->save(new Blog_caurasol_content($content));
        }
        return 1;
    }

    public function show($id)
    {
        $blog_caurasol = Blog_caurasol::find($id);
        //return $blog_caurasol->blog_category;
        return view('admin.modules.blog_caurasol.show',compact('blog_caurasol'));
    }


    public function edit($id)
    {
        $blog_categories = Blog_category::pluck('name','id');
        $blog_caurasol = Blog_caurasol::find($id);
        $contents =  $blog_caurasol->contents;
        return view('admin.modules.blog_caurasol.edit',compact('blog_caurasol','blog_categories','contents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $blog_caurasol = Blog_caurasol::find($id);
        $blog_caurasol->fill($request->only(['title','blog_category_id','link']))->save();
        $blog_caurasol->contents()->delete();
        foreach ($request->ad_content as $content){
            $content['link']  = $content['link'].'?utm_source=bikroy_blog&utm_medium=blog_banners&utm_campaign=blog_post&utm_content=300x200';
            $blog_caurasol->contents()->save(new Blog_caurasol_content($content));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Blog_caurasol::find($id)->delete();
    }
    public function scrap_data(Request $request){
        $url = $request->link;
        $dom = HtmlDomParser::file_get_html($url);
        $container = $dom->find('div.serp-items')[0];
        $item_array = [];
        foreach($container->find('.ui-item') as $i=>$item){
            if($i<5){
                if($item->find('img',0)){
                    $image = generate_fitted_image($item->find('img',0)->getAttribute('data-srcset'));
                    $item_array[$i]['image']        = generate_custom_image_path($image,'100/100');
                }else{
                    $item_array[$i]['image'] = null;
                }
                $item_array[$i]['title']        = $item->find('.item-title',0)->plaintext;
                $item_array[$i]['job_provider'] = ($item->find('.item-meta',0)) ? $item->find('.item-meta',0)->plaintext : null;
                $item_array[$i]['is_member']    = ($item->find('.is-member')) ? true: false;
                $item_array[$i]['location']     = ($item->find('.item-area',0)) ? $item->find('.item-area',0)->plaintext: null;
                $item_array[$i]['item_cat']     = ($item->find('.item-cat',0)) ? $item->find('.item-cat',0)->plaintext: null;
                $item_array[$i]['price']        = ($item->find('.item-info',0)) ? $item->find('.item-info',0)->plaintext: null;
                $item_array[$i]['link']         = 'https://bikroy.com'.$item->find('.item-title',0)->getAttribute('href');
            }
        }
        return $item_array;
    }
}
