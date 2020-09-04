<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        @stack('styles')
        
        @livewireStyles

        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        <div id="app">
            @yield('body')
        </div>

        @livewireScripts

        <script src="{{ mix('js/app.js') }}"></script>

        @stack('scripts')
    </body>
</html>