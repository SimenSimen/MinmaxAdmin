<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{ $webData->website_name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('components/elFinder/css/elfinder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('components/elFinder/css/theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('components/elFinder/themes/windows-10/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}">
    @stack('styles')
</head>
<body>
<div class="wrapper">
    @include('administrator.layouts._header')

    <div class="border-box page-content">
        <div class="content-header">
            <div class="row justify-content-between">
                <div class="col-auto">
                    @yield('breadcrumbs')
                </div>
            </div>
        </div>

        <div class="content-body">
            @include('administrator.layouts._alerts')

            @yield('content')
        </div>
    </div>

    @include('administrator.layouts._sidebar')

    <footer class="page-footer small p-2">
        <p class="mb-0">{{ date('Y') }} © {{ env('APP_AUTHOR') }}. design by <a href="{{ env('APP_AUTHOR_URL') }}" target="_blank">{{ env('APP_AUTHOR') }}</a></p>
    </footer>
</div>

@include('administrator.layouts._footJs')
</body>
</html>