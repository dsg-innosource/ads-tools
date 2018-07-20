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
        <div class="flex items-center flex-no-shrink text-white mr-6 p-2">
            <img src="{{url('/vendor/foreflow/img/foreflogo.png')}}" class="h-8" alt="">
        </div>
        <div class="flex items-center flex-1 justify-end mr-8">
            <div class="flex group hover:bg-grey-lighter h-full items-center">
                <div class="flex relative px-4 cursor-pointer">
                    <div class="mr-1 text-grey-darker">Admin</div>
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    <div class="hidden flex-col text-sm absolute mt-8 min-w-full pin-r bg-white shadow group-hover:flex cursor-default rounded-b border-t">

                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div id="ads-tools" class="bg-grey-lighter min-h-screen p-4">
        @yield('content')
    </div>
    <script src="{{ mix('js/app.js', 'vendor/ads-tools') }}"></script>
</body>
</html>