@props(['hideHeader' => false])
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
    @unless ($hideHeader)
        {{-- Header par defaut pour les pages sans hero photo (connexion, mon compte...).
             La page d'accueil affiche son propre header transparent dans le hero. --}}
        <header class="flex items-center justify-between px-6 py-5 sm:px-12">
            <a href="{{ route('home') }}" class="text-lg font-bold tracking-wide">VOTRE-MARQUE</a>

            @guest
                <a href="{{ route('login') }}" class="rounded-[var(--radius-pill)] border border-[color:var(--color-border)] px-5 py-2 text-sm">
                    Connexion
                </a>
            @endguest
            @auth
                <div class="flex items-center gap-4 text-sm">
                    <a href="{{ route('account') }}">Mon compte</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-[var(--radius-pill)] border border-[color:var(--color-border)] px-5 py-2">
                            Deconnexion
                        </button>
                    </form>
                </div>
            @endauth
        </header>
    @endunless

    {{ $slot }}

    @livewireScripts
</body>
</html>
