<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="msapplication-TileColor" content="#ff685c">
    <meta name="theme-color" content="#32cafe">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon.ico')}}" />

    <!-- Title -->
    @yield('page-title')
    <link rel="stylesheet" href="{{asset('assets/fonts/fonts/font-awesome.min.css')}}">

    <!-- Font family -->
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700" rel="stylesheet">

    <!-- Dashboard Css -->
    <link href="{{asset('assets/css/dashboard.css')}}" rel="stylesheet" />
    <!-- select2 Plugin -->
    <link href="{{asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
    <!-- c3.js Charts Plugin -->
    <link href="{{asset('assets/plugins/charts-c3/c3-chart.css')}}" rel="stylesheet" />

    <!-- Custom scroll bar css-->
    <link href="{{asset('assets/plugins/scroll-bar/jquery.mCustomScrollbar.css')}}" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" />

    <!-- Horizontal-menu Css -->
    <link href="{{asset('assets/plugins/horizontal-menu/dropdown-effects/fade-down.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/horizontal-menu/webslidemenu.css')}}" rel="stylesheet">

    <!---Font icons-->
    <link href="{{asset('assets/plugins/iconfonts/plugin.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/iconfonts/icons.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/bootstrep-datepicker.css')}}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
</head>
