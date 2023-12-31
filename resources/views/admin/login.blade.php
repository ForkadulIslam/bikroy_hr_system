﻿<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Bikroy Self Service</title>
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
</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">Employee Self Service</a>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_in" method="POST" action="{!! URL::to('login') !!}">
                    {!! Form::token() !!}
                    <div class="msg">Sign in to start your session</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="email" placeholder="Username" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">

                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-teal waves-effect" type="submit">SIGN IN</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        {{--<div class="col-xs-6">--}}
                            {{--<a href="sign-up.html">Register Now!</a>--}}
                        {{--</div>--}}
                        {{--<div class="col-xs-6 align-right">--}}
                            {{--<a href="forgot-password.html">Forgot Password?</a>--}}
                        {{--</div>--}}
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="{!! generate_asset_url('public/plugins/jquery/jquery.min.js') !!}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{!! generate_asset_url('public/plugins/bootstrap/js/bootstrap.js') !!}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{!! generate_asset_url('public/plugins/node-waves/waves.js') !!}"></script>

    <!-- Validation Plugin Js -->
    <script src="{!! generate_asset_url('public/plugins/jquery-validation/jquery.validate.js') !!}"></script>

    <!-- Custom Js -->
    <script src="{!! generate_asset_url('public/js/admin.js') !!}"></script>
    <script src="{!! generate_asset_url('public/js/pages/examples/sign-in.js') !!}"></script>
</body>

</html>
