<?php

use Illuminate\Support\Facades\File;

function is_secured(){
    return true;
}
function menu_array(){
    return [
        [
            'label'=>'Home',
            'icon'=>'home',
            'link'=>URL::to('/')
        ],
        [
            'label'=>'Jobs Banner',
            'icon'=>'assignment_turned_in',
            'link'=>'#',
            'sub'=>[
                [
                    'label'=>'Create',
                    'link'=>URL::to('module/banner/create')
                ],
                [
                    'label'=>'List',
                    'link'=>URL::to('module/banner')
                ],
            ]
        ],
    ];
}
function generate_custom_image_path($path,$dimension){
    $path_arrs = explode('/',$path);
    $custom_path = '';
    foreach($path_arrs as $i=>$path_arr){
        if($i< count($path_arrs)-3){
            $custom_path.=$path_arr.'/';
        }
        if($i == count($path_arrs)-1){
            $custom_path .= $dimension.'/'.$path_arr;
        }
    }
    return $custom_path;
}
function generate_fitted_image($str){
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
    return $fitted_img;
}
function delete_directory($path){
    if (File::exists($path)) File::deleteDirectory($path);
}
function get_sizes(){
    $size_arr =  [
        '970x150'=>'970x150 (D Leaderboard)',
        '970x250'=>'970x250 (D Bottom Leaderboard)',
        '320x100'=>'320x100 (Mobile WEB)',
        '320x100_mobile'=>'320x100 (APP)',
    ];
    return $size_arr;
}
function get_custom_title($title){
    $title = trim($title);
    if(!empty($title)){
        $sub_str = explode(' ',substr($title,0,20));
        $title_arr = explode(' ',$title);
        $final_title = [];
        foreach($sub_str as $i=>$s){
            if($title_arr[$i] == $s){
                $final_title[]= $s;
            }
        }
        $arr = [];
        foreach($final_title as $i=>$title){
            if($i == count($final_title)-1){
                if($title !== '&'){
                    $arr[] = $title;
                }
            }else{
                $arr[] = $title;
            }
        }
        //return $arr;
        $final_title = $arr;
        return implode(' ',$final_title);

    }
}
function site_urls(){
    return [
        'deals'=>'https://bikroy.com/en/shops/bikroy-deals',
        'web'=>'https://bikroy.com/',
        'root_of_html_content'=>'bikroy'
    ];
}
function generate_asset_url($path){
    return 'https://bikroyit.com/adcrm_assets/bikroy/'.$path;
}
function file_transfer($path,$module){
    $target_url = 'https://bikroyit.com/html_banner/upload.php'; // Write your URL here
    $dir = realpath($path); // full directory of the file ex: html_contents/cricket_world_cup.zip
    //return $dir;

    $cFile = curl_file_create($dir);
    $post = array('file'=> $cFile, 'content_directory_name'=>site_urls()['root_of_html_content'], 'module'=>$module); // Parameter to be sent

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $target_url);
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result =   curl_exec($ch);
    curl_close ($ch);
    //unlink($dir);
    return $result;
}