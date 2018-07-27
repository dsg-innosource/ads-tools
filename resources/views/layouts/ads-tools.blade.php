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
<body class="font-light text-grey-dark">
    <div class="min-h-screen max-h-screen flex flex-col">
        <nav class="flex bg-white border-b p-4 flex-no-shrink">
            <div class="mr-4">ADS Tools</div>
            <a class="no-underline text-orange text-sm" href="{{route('ads-tools.connections.index')}}">Connections</a>
        </nav>
        <div id="ads-tools" class="bg-grey-lighter flex flex-1 p-4">
            @yield('content')
        </div>
    </div>
    <script src="{{ mix('js/app.js', 'vendor/ads-tools') }}"></script>
</body>
</html>