<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'QuickClean')</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; background: #f4f6fa; font-family: 'Segoe UI', sans-serif; }
    </style>
    @stack('styles')
</head>
<body>
    @yield('content')
    @stack('scripts')
</body>
</html>