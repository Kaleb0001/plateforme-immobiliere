# Module 10, partie 2 — Recherche / résultats

## Ce que contient cette livraison

**Page de résultats** (`/biens`) : filtres réellement fonctionnels (transaction, ville, type, style, budget min/max), mise à jour en direct sans rechargement de page (Livewire), pagination, réinitialisation des filtres. Les critères sont dans l'URL (`/biens?transaction=vente&city_id=1...`), donc une recherche est partageable par lien.

**Le widget de recherche de l'accueil fonctionne enfin réellement** : il soumet vers `/biens` avec les bons filtres pré-remplis, au lieu d'être décoratif.

**Liens de navigation connectés** : "Acheter un bien" et "Louer" (en-tête du hero, en-tête flottant au scroll, footer) pointent maintenant vers la recherche filtrée correspondante ; "Vendre un bien" pointe vers l'inscription. "À propos" et "Ressources" restent en attente (dernière partie du module 10).

## Fichiers (7 fichiers, zip)
- `app/Livewire/PropertySearch.php`, `resources/views/livewire/property-search.blade.php` — nouveaux
- `resources/views/sections/hero.blade.php` — remplace (formulaire fonctionnel + liens)
- `resources/views/home.blade.php` — remplace (liens de l'en-tête flottant)
- `database/seeders/HomePageSeeder.php` — remplace (liens du footer)
- `routes/web.php` — remplace (route `/biens`)

## Étapes chez toi
```bash
# Copier les fichiers par-dessus les precedents

php artisan migrate:fresh --seed

# Reattribuer le role super_admin (perdu par le migrate:fresh)
php artisan tinker
>>> App\Models\User::where('email', 'admin@gmail.com')->first()->assignRole('super_admin');
>>> exit

composer run dev
```

Teste depuis l'accueil : change la ville/le type dans le widget de recherche et clique "Rechercher" → tu arrives sur `/biens` avec les bons résultats déjà filtrés. Change encore les filtres sur cette page directement pour voir la mise à jour en direct.

## Ce qu'il reste pour clore le module 10
Espace client (favoris + suivi des soumissions) et page à propos. Dis-moi quand tu veux continuer.
