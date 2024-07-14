<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php if (isset($page['props']['shot'])):?>

        <meta property="og:url" content="{{$page['props']['shot']['links']['url']}}">
        <meta property="og:title" content="{{$page['props']['shot']['name']}}" />
        <meta property="og:description" content="An image shared on ShotShare" />

        <?php if (isset($page['props']['shot']['links']['asset_url'])): ?>

        <meta property="og:image" content="{{$page['props']['shot']['links']['asset_url']}}"/>

        <?php endif; ?>

        <?php endif; ?>

        <title inertia>{{ config('app.name', 'ShotShare') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased dark">
        @inertia
    </body>
</html>
