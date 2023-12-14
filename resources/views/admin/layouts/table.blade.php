<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
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

    <!-- Custom Css -->
    <link href="{!! generate_asset_url('public/css/style.css') !!}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{!! generate_asset_url('public/css/themes/all-themes.css') !!}" rel="stylesheet" />
    <link rel="stylesheet" href="{!! generate_asset_url('public/plugins/sweetalert/sweetalert.css') !!}">
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

<!-- Custom Js -->
<script src="{!! generate_asset_url('public/js/admin.js') !!}"></script>
<script src="{!! generate_asset_url('public/plugins/sweetalert/sweetalert.min.js') !!}"></script>
<script src="{!! generate_asset_url('public/js/vue.js') !!}"></script>
<script src="{!! generate_asset_url('public/js/helpers.js') !!}" type="text/javascript"></script>

<script type="text/javascript">
    $('document').ready(function(){
        $(document).on({
            click:function(e){
                e.preventDefault();
                delete_with_swal($(this).attr('href'),'{!! csrf_token() !!}',$(this).closest('tr'));
            }
        },'.delete_with_swal');
        $('[data-toggle="tooltip"]').tooltip();

    });
</script>
@yield('custom_page_script')
<div id="snackbar">Code hasbeen copied...</div>
</body>

</html>