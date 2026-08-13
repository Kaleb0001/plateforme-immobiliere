<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $message = '';
    public bool $sent = false;
    public ?string $throttleMessage = null;

    public function send(): void
    {
        // Limitation de débit (§8) : anti-spam sur le formulaire de contact,
        // par IP, sans exiger de compte.
        $throttleKey = 'contact|'.request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $minutes = (int) ceil(RateLimiter::availableIn($throttleKey) / 60);
            $this->throttleMessage = "Trop de messages envoyés récemment. Réessayez dans environ {$minutes} minute(s).";

            return;
        }

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        RateLimiter::hit($throttleKey, 600);

        ContactMessage::create($validated);

        $this->reset(['name', 'email', 'message']);
        $this->throttleMessage = null;
        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
