<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container mx-auto">
        <x-header/>
        <div id="content">
            {{ $slot }}
        </div>
        <x-footer/>
    </div>
    @if (auth()->check() && $roleNormalUser->is(auth()->user()->role))
        <x-chat-box/>
    @endif
    @stack('script')
</body>
</html>