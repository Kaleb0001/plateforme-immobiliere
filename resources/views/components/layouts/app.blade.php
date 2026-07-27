<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="preconnect" href="https://api.fontshare.com">
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased">
    <nav class="flex items-center justify-end gap-4 px-6 py-4 text-sm">
        @guest
            <a href="{{ route('login') }}">Connexion</a>
            <a href="{{ route('register') }}">Inscription</a>
        @endguest
        @auth
            <a href="{{ route('account') }}">Mon compte</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Se deconnecter</button>
            </form>
        @endauth
    </nav>

    {{ $slot }}

    @livewireScripts
</body>
</html>
