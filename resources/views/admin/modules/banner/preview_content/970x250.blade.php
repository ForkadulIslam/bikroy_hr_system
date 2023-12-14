<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{!! $banner->title !!}</title>
    <!-- Favicon-->
    <link rel="icon" href="{!! generate_asset_url('public/favicon.ico') !!}" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet prefetch" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="{!! generate_asset_url('public/css/ticker.min.css') !!}">
    <script type="text/javascript" src="{!! generate_asset_url('public/js/ticker.min.js') !!}"></script>

    <style>
        body{
            margin:0px;
            padding:0px;
        }
        .ad_content_holder{
            width:970px;
            position: relative;
            height:250px;
            padding:0px;
            margin:0px;
        }
        .slider {
            color: white;
            background: #e7edee;
        }
        .slide{
            background-color:#e7edee;
            //padding:5px 5px;
            border-radius:5px;
            position:relative;
            margin-right:50px;
            overflow: hidden;
            height:120px;
            text-align: center;
            line-height:120px;
        }
        .img_box img{
            vertical-align: middle;
            max-height: 120px;
            max-width: 204px;
        }

    </style>
</head>
<body>

<div class="container-fluid" style="padding-left:0%">
    <div class="row">
        <div class="col-xs-12">
            <div class="ad_content_holder">
                @if(!isset($process_transfer))
                    <img class="" src="{!! asset('html_contents/'.$banner->id.'/'.$banner->image) !!}" alt="Jobs Top Image">
                @else
                    <img class="" src="{!! $banner->image !!}" alt="Jobs Top Image">
                @endif
                <div class="slider default-ticker">
                    @foreach($banner->contents as $content)
                        <a class="{!! $content->link === '' || $content->link === '#' ? 'do_nothing_on_click' : '' !!}" href="{!! $content->link !!}" target="_blank">
                            <div class="slide">
                                <div class="content">
                                    <div class="img_box">
                                        @if(!isset($process_transfer))
                                            <img class="" src="{!! asset('html_contents/'.$banner->id.'/'.$content->image) !!}" alt="Product image">
                                        @else
                                            <img class="" src="{!! $content->image !!}" alt="Product image">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('.slider').on('click','.do_nothing_on_click',function(e){
            e.preventDefault();
        });
        $(".default-ticker").ticker({
            item: 'a',
            pauseOnHover: true,
            speed: 50,
            pauseAt: '',
            delay: 500,
        });
    })
</script>
</body>
</html>