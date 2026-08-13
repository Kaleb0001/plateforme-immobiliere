<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        // Limitation de débit (§8) : au-delà de 5 inscriptions par heure et
        // par IP, on bloque plutôt que de laisser un script créer des
        // comptes en masse.
        $throttleKey = 'register|'.request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $minutes = (int) ceil(RateLimiter::availableIn($throttleKey) / 60);
            $this->addError('email', "Trop de tentatives d'inscription depuis cet appareil. Réessayez dans environ {$minutes} minute(s).");

            return;
        }

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        RateLimiter::hit($throttleKey, 3600);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?: null,
            'password' => Hash::make($validated['password']),
        ]);

        // Tout visiteur qui s'inscrit devient "client" par defaut
        // (favoris + soumission de biens).
        $user->assignRole('client');

        Auth::login($user);

        session()->regenerate();

        $this->redirect(route('account'));
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
