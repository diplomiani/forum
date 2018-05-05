<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">


    <script type="text/javascript">
        window.App = {!! json_encode([
            'csrfToken' => csrf_token(),
            'signdIn' => Auth::check(),
            'user' => Auth::user(),
        ]) !!};
    </script>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style type="text/css">
        .level{
            display: flex;
            align-items: center;
        }
        .flex{flex: 1}
        .mr-1{ margin-right: 1em; }
        [v-cloak]{ display: none; }
    </style>
</head>
<body style="padding-bottom: 100px">
    <div id="app">
       @include('layouts.nav')

        <main class="py-4">
            @yield('content')
        </main>
        <flash message="{{ session('flash') }}"></flash>
    </div>
</body>
</html>
