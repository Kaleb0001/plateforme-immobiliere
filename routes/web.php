<?php

use Illuminate\Support\Facades\Route;

// Route temporaire : la vraie page d'accueil (sections modulables) arrive au module 6.
Route::view('/', 'welcome')->name('home');
