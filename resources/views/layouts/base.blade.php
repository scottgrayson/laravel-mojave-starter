<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! app('seotools')->generate(true) !!}

    @yield('meta')

    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('apple-icon-72x72.png') }}">
    {{-- <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('android-icon-192x192.png') }}"> --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    {{-- <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}"> --}}
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('style')

    <!-- Before Scripts -->
    @includeWhen(
    app()->environment('staging', 'production'),
    'vendor.rollbar', [
    'token' => config('services.rollbar.js_token'),
    'env' => config('app.env'),
    ])

    <script>
      window.app = <?php echo json_encode([
        'csrfToken' => csrf_token(),
        'pusherKey' => config('services.pusher.auth_key'),
      ]); ?>;
      window.User = {!! auth()->check() ? auth()->user()->jsObject() : 'false' !!}
    </script>

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

  <body class="svg-background">
    <div id="app">
      @yield('body')
      @include('flash::message')
    </div>

    <!-- After Scripts -->
    @yield('beforeAppScripts')
    {{--<script src="{{ mix('js/vendor.js') }}"></script>--}}
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('scripts')

    @include('vendor.analytics')
  </body>
</html>
