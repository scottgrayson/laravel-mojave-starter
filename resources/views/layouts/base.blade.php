<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
      {{ config('app.name', 'Mojave') }} - @yield('title')
    </title>

    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">

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

  </head>

  <body>

    <div id="app">
      @yield('body')
      @include('flash::message')
    </div>

    <!-- After Scripts -->
    @yield('beforeAppScripts')
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('scripts')

  </body>
</html>
