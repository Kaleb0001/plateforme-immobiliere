<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    /**
     * Limitation de débit (§8 du cahier des charges) : au-delà de 5
     * tentatives, on bloque une minute plutôt que de laisser un script
     * tester des mots de passe en boucle. Clé par email + IP, comme le
     * fait le scaffolding officiel de Laravel (Breeze/Fortify).
     */
    private function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email)).'|'.request()->ip();
    }

    public function login(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            $seconds = RateLimiter::availableIn($this->throttleKey());
            $this->addError('email', "Trop de tentatives de connexion. Réessayez dans {$seconds} secondes.");

            return;
        }

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey(), 60);
            $this->addError('email', 'Ces identifiants ne correspondent à aucun compte.');

            return;
        }

        RateLimiter::clear($this->throttleKey());
        request()->session()->regenerate();

        $this->redirect(route('account'));
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
