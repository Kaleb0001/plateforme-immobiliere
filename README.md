# Module 3 — Modelisation des donnees

Confirme sur tes 3 captures : fondations posees, connexion admin fonctionnelle, Filament v4.12.3 actif. On enchaine.

## Ce que contient ce module
- `app/Enums/` : TransactionType, PropertyStatus, ContactMessageStatus, SectionType
- `app/Models/` : User (modifie), City, PropertyType, PropertyStyle, Property, ContactMessage, FaqItem, Page, Section
- `database/migrations/` : 10 migrations (biens, taxonomies, favoris, messages, FAQ, pages/sections)
- `database/seeders/` : RoleSeeder (4 roles), TaxonomySeeder (donnees d'exemple), DatabaseSeeder mis a jour

## Nouvelle dependance a ajouter
On a besoin d'un generateur de slug (`spatie/laravel-sluggable`) pour les URLs propres des biens/villes/types. Attention : sa version 4 exige PHP 8.3+, donc je fixe explicitement la version 3 pour rester compatible avec ton PHP 8.2 :

```bash
composer require spatie/laravel-sluggable:"^3.0"
```

## Etapes a suivre chez toi

```bash
# 1. Installer la nouvelle dependance
composer require spatie/laravel-sluggable:"^3.0"

# 2. Copier les fichiers de ce module par-dessus (en conservant l'arborescence) :
#    - app/Enums/* (nouveaux fichiers)
#    - app/Models/* (User.php REMPLACE le fichier existant, le reste est nouveau)
#    - database/migrations/* (nouveaux fichiers)
#    - database/seeders/* (DatabaseSeeder.php REMPLACE le fichier existant, le reste est nouveau)

# 3. Executer les migrations
php artisan migrate

# 4. Executer les seeders (roles + donnees d'exemple)
php artisan db:seed

# 5. Attribuer le role super_admin a ton compte admin existant (celui vu dans tes captures)
php artisan tinker
>>> App\Models\User::where('email', 'admin@gmail.com')->first()->assignRole('super_admin');
>>> exit
```

**Important** : `User` implemente maintenant `canAccessPanel()`, qui limite l'acces a `/admin` aux `super_admin` et `admin`. Sans l'etape 5, ton compte actuel sera bloque a la prochaine connexion — pense a l'executer avant de retourner sur `/admin`.

## Verification (pas encore d'ecran dans l'admin pour ca, c'est le module 7)
Le plus simple est `php artisan tinker` :

```php
>>> App\Models\City::count();            // 3
>>> App\Models\PropertyType::count();    // 5
>>> App\Models\City::first()->slug;      // "paris"
>>> App\Models\User::first()->getRoleNames(); // devrait contenir "super_admin"
```

## Extensions PHP a verifier (en plus de intl/pdo_pgsql/pgsql/gd deja mentionnes)
`spatie/laravel-medialibrary` a besoin de `ext-exif` et `ext-fileinfo` en plus de `gd`. Meme logique dans `php.ini` : decommenter `extension=exif` et `extension=fileinfo` si elles n'y sont pas deja (fileinfo est generalement deja active par defaut sur XAMPP).

## Point d'attention pour plus tard (pas d'action requise maintenant)
Le modele `Property` utilise Scout (`Searchable`) en prevision du module recherche, avec `SCOUT_DRIVER=meilisearch` deja dans `.env`. Ce module ne cree encore aucun bien (seulement des villes/types/styles, qui n'utilisent pas Scout), donc rien ne se declenche pour l'instant. Quand on creera les premiers biens (module 7 ou tests), il faudra soit avoir Meilisearch installe en local, soit basculer temporairement sur le driver `database` de Scout — on verra ca a ce moment-la.

## Decisions retenues
- Taxonomies (villes, types, styles) en vraies tables plutot qu'en enums, comme prevu au cahier des charges — permet a l'admin de les gerer et prepare les futures pages SEO par ville/type.
- `PropertyStatus`, `TransactionType`, `ContactMessageStatus`, `SectionType` en enums PHP natifs (8.1+), stockes en `string` en base — plus portable qu'un enum SQL, plus simple a faire evoluer.
- Donnees du seeder (Paris/Lyon/Marseille, etc.) : purement des exemples de developpement/test, a ignorer ou remplacer sans consequence.
