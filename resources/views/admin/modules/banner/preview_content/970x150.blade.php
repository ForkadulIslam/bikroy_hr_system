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
            height:150px;
            padding:0px;
            margin:0px;
        }
        .slider {
            color: white;
        }
        .slide{
            background-color:#fff;
            padding:5px 5px;
            border-radius:5px;
            position:relative;
            margin-right:50px;
            overflow: hidden;
            height:110px;
            text-align: center;
            line-height:110px;
        }
        .title{
            padding: 0;
            font-size: 19px;
            font-weight: 700;
            display: inline-block;
            float: left;
            margin: 4px 11px 4px 0;
        }
        .img_box img{
            vertical-align: middle;
            max-height: 110px;
            max-width: 204px;
        }
        .job_stats{
            display: inline-block;
            margin: 0;
            vertical-align: middle;
            font-weight: 700;
            float: left;
        }
        .job_stats img{
            width: 30px;
            border: 2px solid #0074ba;
            padding: 3px;
            border-radius: 30px;
            height: 30px;
            animation-name: blinking;
            animation-duration: 2s;
            animation-iteration-count: 100;
        }
        @keyframes blinking {
            50% {
                border-color: #ffcd5f;
            }
        }
        .job_stats span{
            vertical-align: middle;
            display: inline-block;
            margin-right: 2px;
            color: #424e4e;
            font-size: 12px;
            font-weight: 900;
            animation-name: blinking_test;
            animation-duration: 1s;
            animation-iteration-count: 100;
        }
        @keyframes blinking_test {
            50% {
                color: #0074ba;
            }
        }

    </style>
</head>
<body>

<div class="container-fluid" style="padding-left:0%">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="title">Featured Employers</h2>

            <div class="job_stats">
                @if($banner->market === 'Bikroy')
                <span>1,261 live jobs</span>
                <img src="http://bikroyit.com/assets/images/live_jobs.png" alt="Jobs stats image">
                @endif
            </div>
        </div>
        <div class="col-xs-12">
            <div class="ad_content_holder">
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