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
        {{-- Sticky : reste visible en haut pendant le defilement sur les pages
             sans hero photo (connexion, mon compte...). --}}
        <header class="sticky top-0 z-50 flex items-center justify-between bg-[color:var(--color-surface)]/95 px-6 py-5 shadow-sm backdrop-blur sm:px-12">
            <a href="{{ route('home') }}" class="text-lg font-bold tracking-wide">VOTRE-MARQUE</a>

            @guest
                <a href="{{ route('login') }}" class="rounded-[var(--radius-pill)] border border-[color:var(--color-border)] px-5 py-2 text-sm transition hover:bg-[color:var(--color-ink)] hover:text-white">
                    Connexion
                </a>
            @endguest
            @auth
                <div class="flex items-center gap-4 text-sm">
                    <a href="{{ route('account') }}" class="transition hover:opacity-70">Mon compte</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-[var(--radius-pill)] border border-[color:var(--color-border)] px-5 py-2 transition hover:bg-[color:var(--color-ink)] hover:text-white">
                            Déconnexion
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
