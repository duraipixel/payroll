<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>&nbsp;{{ config('app.name', 'AWES') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body id="kt_body" class="app-blank app-blank"> 
    <div class="d-flex flex-column flex-root" style="min-height: 100%;" id="kt_app_root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">

            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
                style="background-image: url({{ asset('assets/media/misc/auth-bg.png') }})">

                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">

                    <div class="d-flex gap-5 mb-3">
                        <div>
                            <img alt="Logo" src="{{ asset('assets/logo/shield-logo.png') }}" width="100px" />
                        </div>
                        <div>
                            <img alt="Logo" src="{{ asset('assets/logo/logo.png') }}" width="120px" />
                        </div>
                    </div>
                    <h4 class="text-white"> FROM STUDENTS TO LEADERS OF TOMORROW</h4>
                </div>
            </div>
            <div class="d-flex align-items-center w-lg-50 p-10 order-2 order-lg-2">
                @yield('content')
            </div>
        </div>
    </div> 
</body>

</html>
