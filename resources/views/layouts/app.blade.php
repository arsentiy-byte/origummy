<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="@stack('html-class')">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Origummy - Sushi & Pizza') }}</title>

    {{-- Scripts --}}
    @stack('head-scripts')

    {{-- Fonts --}}
    @stack('fonts')

    {{-- Styles --}}
    @stack('styles')

    @stack('head-after')
</head>
<body>

<div id="app">

    @yield('content')

</div>

@stack('bottom')

</body>
</html>
