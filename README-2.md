# Module 2 — Fondations Laravel / Filament / Livewire

## Ajustement pour ta version de PHP (8.2.12)

C'est cohérent : `composer create-project laravel/laravel` sans version choisit la dernière version compatible avec le PHP installé. Comme Laravel 13 exige PHP 8.3+, Composer t'a donné **Laravel 12** — la version juste en dessous, qui accepte PHP 8.2+. Rien d'anormal, et pas besoin de toucher à ton PHP : `composer.json` est maintenant aligné sur **Laravel 12 + PHP 8.2**, avec **Filament v4** (compatible avec Laravel 12 aussi bien qu'avec Laravel 13).

À savoir, pour information, sans obligation d'agir : Laravel 12 arrête de recevoir des corrections de bugs le 13 août 2026, mais garde les correctifs de sécurité jusqu'au 24 février 2027 — largement le temps de voir venir. Le jour où tu voudras passer à PHP 8.3+/Laravel 13, la migration est annoncée sans rupture de compatibilité. Pas pressé.

## Pourquoi ton `composer install` avait échoué (rappel)

`composer.json` avait été remplacé après que `composer create-project` avait déjà généré un `composer.lock` pour le squelette par défaut — les deux ne correspondaient plus. La solution reste la même : régénérer le lock avec `composer update`.

## Étapes à suivre chez toi

```bash
# Dans le dossier du projet déjà créé (plateforme-immobiliere)

# 1. Supprimer le lock existant (il ne correspond plus au nouveau composer.json)
del composer.lock          # Windows (cmd)

# 2. Copier tous les fichiers de ce module par-dessus, en conservant l'arborescence
#    (composer.json, package.json, vite.config.js, .env.example, config/app.php,
#     bootstrap/providers.php, routes/web.php, resources/css/*, resources/js/app.js,
#     resources/views/components/layouts/app.blade.php, resources/views/welcome.blade.php)

# 3. Regenerer le lock et installer (Laravel 12, Filament 4, Livewire 3, Spatie, Scout)
composer update

# 4. Fichier d'environnement + cle d'application
copy .env.example .env
php artisan key:generate

# 5. Adapter .env si besoin (identifiants PostgreSQL, Meilisearch)

# 6. Migrations de base (table users, etc. - etoffee au module 3)
php artisan migrate

# 7. Installer le panneau Filament avec le generateur officiel
php artisan filament:install --panels

# 8. Ouvrir le fichier genere app/Providers/Filament/AdminPanelProvider.php
#    et ajouter cette ligne dans la chaine de configuration du panel (apres ->path('admin')) :
#
#        ->colors([
#            'primary' => \Filament\Support\Colors\Color::hex('#242424'),
#        ])

# 9. Creer le premier compte administrateur
php artisan make:filament-user

# 10. Traductions FR des messages de validation/auth natifs de Laravel
composer require laravel-lang/common --dev
php artisan lang:add fr

# 11. Dependances front
npm install

# 12. Lancer le projet - une seule commande, un seul terminal
composer run dev
```

Une fois lancé :
- `http://localhost:8000` → page de vérification des fondations (remplacée par la vraie page d'accueil au module 6)
- `http://localhost:8000/admin` → panneau Filament (connexion avec le compte créé à l'étape 9)

## Si `composer update` bute sur une dépendance liée à PHP 8.2
Un paquet secondaire de Filament (`openspout`, utilisé pour les exports Excel) a récemment relevé son minimum à PHP 8.3 dans ses toutes dernières versions. Composer doit normalement résoudre automatiquement vers une version compatible avec PHP 8.2 (Filament l'autorise dans sa plage de versions) — mais si jamais l'installation échoue précisément sur ce paquet, dis-le-moi et j'ajusterai la contrainte.

## Ce qui a changé par rapport aux envois précédents
- `composer.json` : Laravel 12 (au lieu de 13), PHP 8.2 (au lieu de 8.3+) — aligné sur ton environnement actuel
- Filament reste en v4, le fichier `AdminPanelProvider.php` est généré par `filament:install --panels`, tu ajoutes juste la couleur
- Layout en convention Blade component de Livewire v3 (`x-layouts.app` / `{{ $slot }}`)

## Hypothèses retenues (à corriger si besoin)
- Nom de projet provisoire (`Plateforme Immobiliere` / `votre-org/plateforme-immobiliere`) — dis-moi le vrai nom de la marque quand tu l'auras.
- Environnement local natif (PHP/Composer/Node installés directement), pas de Docker/Sail.
- Couleur "primary" du panneau Filament : notre `ink` (#242424).
