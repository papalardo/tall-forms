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
        @yield('body')

        @livewireScripts

        <script src="{{ mix('js/app.js') }}"></script>
        
        <script type="module" src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
        <script nomodule src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine-ie11.min.js" defer></script>

        @stack('scripts')
    </body>
</html>