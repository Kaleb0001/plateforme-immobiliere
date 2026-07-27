<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    public function login(): void
    {
        $credentials = $this->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $this->remember)) {
            $this->addError('email', "Ces identifiants ne correspondent a aucun compte.");

            return;
        }

        request()->session()->regenerate();

        //$this->redirect(route('account'), navigate: true);
        $this->redirect(route('account'));
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
