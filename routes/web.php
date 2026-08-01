<?php

use App\Enums\PropertyStatus;
use App\Enums\SectionType;
use App\Enums\TransactionType;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\PropertySearch;
use App\Models\City;
use App\Models\FaqItem;
use App\Models\Page;
use App\Models\Property;
use App\Models\PropertyStyle;
use App\Models\PropertyType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $page = Page::where('slug', 'accueil')->with('sections')->firstOrFail();

    $sectionsData = $page->sections->map(function ($section) {
        $entry = ['section' => $section];
        $config = $section->config ?? [];

        if ($section->type === SectionType::PropertyGrid) {
            $query = Property::query()->where('status', PropertyStatus::Publie->value);

            match ($config['source'] ?? 'latest') {
                'rent' => $query->where('transaction_type', TransactionType::Location->value),
                'featured' => $query->where('featured', true),
                default => $query->latest('id'),
            };

            $entry['properties'] = $query->limit($config['limit'] ?? 3)->get();
        }

        if ($section->type === SectionType::FeaturedShowcase) {
            $entry['property'] = Property::where('featured', true)->first() ?? Property::first();
        }

        if ($section->type === SectionType::HowItWorks) {
            $entry['previewProperties'] = Property::where('status', PropertyStatus::Publie->value)->limit(2)->get();
        }

        if ($section->type === SectionType::Faq) {
            $entry['items'] = FaqItem::where('published', true)->orderBy('order')->get();
        }

        return $entry;
    });

    $featuredProperty = Property::where('featured', true)->first();

    return view('home', [
        'page' => $page,
        'sectionsData' => $sectionsData,
        'cities' => City::orderBy('name')->get(),
        'propertyTypes' => PropertyType::orderBy('name')->get(),
        'propertyStyles' => PropertyStyle::orderBy('name')->get(),
        'ogImage' => $featuredProperty?->getFirstMediaUrl('gallery') ?: null,
    ]);
})->name('home');

// Recherche / resultats
Route::get('/biens', PropertySearch::class)->name('properties.search');

// Fiche bien
Route::get('/biens/{property:slug}', function (Property $property) {
    abort_unless($property->status === PropertyStatus::Publie, 404);

    $similarProperties = Property::where('status', PropertyStatus::Publie->value)
        ->where('id', '!=', $property->id)
        ->when($property->city_id, fn ($query) => $query->where('city_id', $property->city_id))
        ->limit(3)
        ->get();

    return view('properties.show', [
        'property' => $property,
        'similarProperties' => $similarProperties,
    ]);
})->name('properties.show');

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

Route::get('/sitemap.xml', function () {
    $urls = collect([
        ['loc' => url('/'), 'changefreq' => 'daily', 'priority' => '1.0'],
        ['loc' => route('properties.search'), 'changefreq' => 'daily', 'priority' => '0.9'],
    ]);

    Property::where('status', PropertyStatus::Publie->value)->each(function ($property) use ($urls) {
        $urls->push([
            'loc' => route('properties.show', $property),
            'changefreq' => 'weekly',
            'priority' => '0.8',
        ]);
    });

    return response()
        ->view('sitemap', ['urls' => $urls])
        ->header('Content-Type', 'text/xml');
})->name('sitemap');

Route::get('/robots.txt', function () {
    $lines = [
        'User-agent: *',
        'Allow: /',
        'Disallow: /admin',
        'Disallow: /dev',
        '',
        'Sitemap: ' . route('sitemap'),
    ];

    return response(implode("\n", $lines))->header('Content-Type', 'text/plain');
});

if (app()->environment('local')) {
    Route::get('/dev/composants', function () {
        return view('dev.composants', [
            'properties' => Property::with('city')->get(),
        ]);
    })->name('dev.composants');
}
