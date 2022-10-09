<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description')">
    <title>Acreditables | @yield('title')</title>

    {{-- Google Font: Source Sans Pro --}}
    <link rel="stylesheet" href="{{ asset('/assets/fonts/fonts.css') }}">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('/assets/plugins/fontawesome-free/css/all.min.css') }}">
    {{-- Ionicons --}}
    <link rel="stylesheet" href="{{ asset('/assets/icons/ionicons.min.css') }}">
    {{-- Tempusdominus Bootstrap 4 --}}
    <link rel="stylesheet"
        href="{{ asset('/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    {{-- iCheck --}}
    <link rel="stylesheet" href="{{ asset('/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    {{-- JQVMap --}}
    <link rel="stylesheet" href="{{ asset('/assets/plugins/jqvmap/jqvmap.min.css') }}">
    {{-- Theme style --}}
    <link rel="stylesheet" href="{{ asset('/assets/dist/css/adminlte.min.css') }}">
    {{-- overlayScrollbars --}}
    <link rel="stylesheet" href="{{ asset('/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    {{-- Daterange picker --}}
    <link rel="stylesheet" href="{{ asset('/assets/plugins/daterangepicker/daterangepicker.css') }}">
    {{-- summernote --}}
    <link rel="stylesheet" href="{{ asset('/assets/plugins/summernote/summernote-bs4.min.css') }}">
    {{-- Customizable CSS --}}
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
    @yield('links')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        {{-- Preloader --}}
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('/assets/img/logo.png') }}" alt="Logo Universidad" height="60"
                width="60">
        </div>
