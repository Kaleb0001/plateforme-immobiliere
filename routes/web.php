<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route temporaire : la vraie page d'accueil (sections modulables) arrive au module 6.
Route::view('/', 'welcome')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/inscription', Register::class)->name('register');
    Route::get('/connexion', Login::class)->name('login');
});

Route::middleware('auth')->group(function () {
    Route::view('/mon-compte', 'account')->name('account');

    Route::post('/deconnexion', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    })->name('logout');
});

// Page de developpement (vitrine des composants) - non destinee au public,
// desactivee automatiquement en dehors de l'environnement local.
if (app()->environment('local')) {
    Route::get('/dev/composants', function () {
        return view('dev.composants', [
            'properties' => Property::with('city')->get(),
        ]);
    })->name('dev.composants');
}
