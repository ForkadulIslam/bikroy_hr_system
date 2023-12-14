<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Scrolling Banner Generator</title>
    <!-- Favicon-->
    <link rel="icon" href="{!! generate_asset_url('public/favicon.ico') !!}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{!! generate_asset_url('public/plugins/bootstrap/css/bootstrap.css') !!}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{!! generate_asset_url('public/plugins/node-waves/waves.css') !!}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{!! generate_asset_url('public/plugins/animate-css/animate.css') !!}" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="{!! generate_asset_url('public/plugins/morrisjs/morris.css') !!}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{!! generate_asset_url('public/css/style.css') !!}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{!! generate_asset_url('public/css/themes/all-themes.css') !!}" rel="stylesheet" />
</head>

<body class="theme-red">
<!-- Page Loader -->
@include('admin.includes.page_loader')
<!-- Search Bar -->
@include('admin.includes.search_bar')
<!-- #END# Search Bar -->
<!-- Top Bar -->
@include('admin.includes.nav_bar')
<!-- #Top Bar -->
@include('admin.includes.left_menu_bar')

<section class="content">
    @yield('content')
</section>

<!-- Jquery Core Js -->
<script src="{!! generate_asset_url('public/plugins/jquery/jquery.min.js') !!}"></script>

<!-- Bootstrap Core Js -->
<script src="{!! generate_asset_url('public/plugins/bootstrap/js/bootstrap.js') !!}"></script>

<!-- Select Plugin Js -->
<script src="{!! generate_asset_url('public/plugins/bootstrap-select/js/bootstrap-select.js') !!}"></script>

<!-- Slimscroll Plugin Js -->
<script src="{!! generate_asset_url('public/plugins/jquery-slimscroll/jquery.slimscroll.js') !!}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{!! generate_asset_url('public/plugins/node-waves/waves.js') !!}"></script>

<!-- Jquery CountTo Plugin Js -->
<script src="{!! generate_asset_url('public/plugins/jquery-countto/jquery.countTo.js') !!}"></script>

<!-- Morris Plugin Js -->
<script src="{!! generate_asset_url('public/plugins/raphael/raphael.min.js') !!}"></script>
<script src="{!! generate_asset_url('public/plugins/morrisjs/morris.js') !!}"></script>

<!-- ChartJs -->
<script src="{!! generate_asset_url('public/plugins/chartjs/Chart.bundle.js') !!}"></script>

<!-- Flot Charts Plugin Js -->
<script src="{!! generate_asset_url('public/plugins/flot-charts/jquery.flot.js') !!}"></script>
<script src="{!! generate_asset_url('public/plugins/flot-charts/jquery.flot.resize.js') !!}"></script>
<script src="{!! generate_asset_url('public/plugins/flot-charts/jquery.flot.pie.js') !!}"></script>
<script src="{!! generate_asset_url('public/plugins/flot-charts/jquery.flot.categories.js') !!}"></script>
<script src="{!! generate_asset_url('public/plugins/flot-charts/jquery.flot.time.js') !!}"></script>

<!-- Sparkline Chart Plugin Js -->
<script src="{!! generate_asset_url('public/plugins/jquery-sparkline/jquery.sparkline.js') !!}"></script>

<!-- Custom Js -->
<script src="{!! generate_asset_url('public/js/admin.js') !!}"></script>
<script src="{!! generate_asset_url('public/js/pages/index.js') !!}"></script>



<div id="snackbar">Code hasbeen copied...</div>
</body>

</html>