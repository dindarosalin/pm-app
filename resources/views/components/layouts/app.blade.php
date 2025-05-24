<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title') - Aba Project Manger</title>
    <!-- meta tag -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="@yield('description')">
    <meta name="author" content="Abarobotics">
    <meta name="application-name" content="Abarobotics">
    <meta name="generator" content="Ports Abarobotics">
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="abarobotics, automation company @yield('tag')">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Abarobotics">
    <meta property="og:image" content="{{ asset('/assets/img/favicon.png') }}">
    <meta property="og:image:secure_url" content="{{ asset('/assets/img/favicon.png') }}">
    <link rel="canonical" href="https://abarobotics.com/" />
    <link href="{{ asset('/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('/assets/img/favicon.png') }}" rel="apple-touch-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>
    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- end meta tag -->
    @include('include.css')
    @livewireStyles

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <style>
        #sidebar {
            position: fixed;
            height: 100vh !important;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 11;
            width: 250px;
            overflow: auto;
            transition: all 0.3s;
            background: #008036 url("{{ asset('img/sidebar-bg.svg') }}") no-repeat left bottom;
            box-shadow:
                0 10px 30px -12px rgb(0 0 0 / 42%),
                0 4px 25px 0px rgb(0 0 0 / 12%),
                0 8px 10px -5px rgb(0 0 0 / 20%);
        }

        video {
            background: #222;
            margin: 0 0 20px 0;
            --width: 100%;
            width: var(--width);
            height: calc(var(--width) * 0.75);
        }
    </style>

</head>

<body>
    <div class="wrapper">
        {{-- <div class="body-overlay"></div> --}}
        {{-- @include('components.layouts.sidebar') --}}

        <div id="sidebar">
            @livewire('layouts.sidebar')
        </div>
        <div id="content">
            @include('components.layouts.navbar')
            <section class="main-content">
                <div class="navbar mt-0">
                    @livewire('layouts.breadcrumbs')
                </div>
                {{ $slot }}
            </section>
            @yield('content')
            @include('components.layouts.footer')
        </div>
    </div>
    @include('include.js')
    @stack('scripts')
    @livewireScripts
    <script src="https://unpkg.com/@wotz/livewire-sortablejs@1.0.0/dist/livewire-sortable.js"></script>

</body>

</html>
