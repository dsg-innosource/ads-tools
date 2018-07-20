<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css', 'vendor/ads-tools') }}">

    <title>ADS Tools</title>
    <script>
        window.foreflow = {
            modules: {}
        };
    </script>
    @stack('last')
</head>
<body>
    <nav class="flex justify-between flex-wrap bg-white border-b">
        <a class="p-4 no-underline text-orange" href="{{route('ads-tools.connections.index')}}">Connections</a>
    </nav>
    <div id="ads-tools" class="bg-grey-lighter min-h-screen p-4">
        @yield('content')
    </div>
    <script src="{{ mix('js/app.js', 'vendor/ads-tools') }}"></script>
</body>
</html>