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

    <!-- Colorpicker Css -->
    <link href="{!! generate_asset_url('public/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css') !!}" rel="stylesheet" />

    <!-- Dropzone Css -->
    <link href="{!! generate_asset_url('public/plugins/dropzone/dropzone.css') !!}" rel="stylesheet">

    <!-- Multi Select Css -->
    <link href="{!! generate_asset_url('public/plugins/multi-select/css/multi-select.css') !!}" rel="stylesheet">

    <!-- Bootstrap Spinner Css -->
    <link href="{!! generate_asset_url('public/plugins/jquery-spinner/css/bootstrap-spinner.css') !!}" rel="stylesheet">

    <!-- Bootstrap Tagsinput Css -->
    <link href="{!! generate_asset_url('public/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') !!}" rel="stylesheet">

    <!-- Bootstrap Select Css -->
    <link href="{!! generate_asset_url('public/plugins/bootstrap-select/css/bootstrap-select.css') !!}" rel="stylesheet" />

    <!-- noUISlider Css -->
    <link href="{!! generate_asset_url('public/plugins/nouislider/nouislider.min.css') !!}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{!! generate_asset_url('public/css/style.css') !!}" rel="stylesheet">
    <link href="{!! generate_asset_url('public/css/snackbar.css') !!}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{!! generate_asset_url('public/css/themes/all-themes.css') !!}" rel="stylesheet" />
    <link rel="stylesheet" href="{!! generate_asset_url('public/plugins/sweetalert/sweetalert.css') !!}">
</head>

<body class="theme-red">

<div id="snackbar">Code hasbeen copied...</div>
<!-- Page Loader -->
@include('admin.includes.page_loader')
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

<!-- Bootstrap Colorpicker Js -->
<script src="{!! generate_asset_url('public/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') !!}"></script>

<!-- Dropzone Plugin Js -->
<script src="{!! generate_asset_url('public/plugins/dropzone/dropzone.js') !!}"></script>

<!-- Input Mask Plugin Js -->
<script src="{!! generate_asset_url('public/plugins/jquery-inputmask/jquery.inputmask.bundle.js') !!}"></script>

<!-- Multi Select Plugin Js -->
<script src="{!! generate_asset_url('public/plugins/multi-select/js/jquery.multi-select.js') !!}"></script>

<!-- Jquery Spinner Plugin Js -->
<script src="{!! generate_asset_url('public/plugins/jquery-spinner/js/jquery.spinner.js') !!}"></script>

<!-- Bootstrap Tags Input Plugin Js -->
<script src="{!! generate_asset_url('public/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') !!}"></script>

<!-- noUISlider Plugin Js -->
<script src="{!! generate_asset_url('public/plugins/nouislider/nouislider.js') !!}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{!! generate_asset_url('public/plugins/node-waves/waves.js') !!}"></script>

<!-- Custom Js -->
<script src="{!! generate_asset_url('public/js/admin.js') !!}"></script>
<script src="{!! generate_asset_url('public/js/pages/forms/advanced-form-elements.js') !!}"></script>
<script src="{!! generate_asset_url('public/js/vue.js') !!}"></script>
<script src="{!! generate_asset_url('public/js/axios.js') !!}"></script>
<script src="{!! generate_asset_url('public/js/lodash.js') !!}"></script>
<script src="{!! generate_asset_url('public/plugins/sweetalert/sweetalert.min.js') !!}"></script>
<script src="{!! generate_asset_url('public/js/helpers.js') !!}" type="text/javascript"></script>

@yield('custom_page_script')

</body>

</html>