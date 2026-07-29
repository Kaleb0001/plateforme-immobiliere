# Module 5 — Composants UI reutilisables + animations

## Ce que contient ce module
- `resources/views/components/ui/` : `property-card`, `badge`, `carousel`, `accordion` + `accordion-item`
- `resources/views/components/form/` : `input`, `select`, `button`
- `resources/js/app.js` : ajoute le plugin Alpine `collapse` (animation fluide de l'accordeon) et une directive `x-reveal` reutilisable (apparition en fondu au scroll) — remplace le fichier du module 2
- `database/seeders/PropertyDemoSeeder.php` : 3 biens d'exemple pour visualiser les composants ; `DatabaseSeeder.php` mis a jour pour l'appeler
- `resources/views/dev/composants.blade.php` : page de vitrine pour voir tous les composants ensemble
- `routes/web.php` : ajoute la route `/dev/composants` (desactivee automatiquement hors environnement local) — remplace le fichier du module 4, contient aussi les corrections de la remarque precedente
- `resources/views/components/layouts/app.blade.php` : integre la navigation ajoutee au message precedent — remplace le fichier existant

## Nouvelle dependance front a ajouter
```bash
npm install @alpinejs/collapse
```

## Etapes a suivre chez toi
```bash
# 1. Installer la nouvelle dependance front
npm install @alpinejs/collapse

# 2. Copier les fichiers de ce module par-dessus (en conservant l'arborescence)
#    routes/web.php et resources/views/components/layouts/app.blade.php REMPLACENT
#    les fichiers existants ; database/seeders/DatabaseSeeder.php aussi. Le reste est nouveau.

# 3. Reinitialiser la base avec les nouvelles donnees d'exemple
php artisan migrate:fresh --seed

# 4. Lancer le projet
composer run dev
```

Verification : `http://localhost:8000/dev/composants` → cartes de biens, carrousel (fleches), badges, accordeon FAQ (cliquable, animation fluide), formulaire.

## A savoir
- **Prix affiches en €** : c'est un placeholder en attendant de connaitre ta devise cible — un seul endroit a changer (`property-card.blade.php`) le moment venu.
- **Photos des biens** : aucun media reel n'existe encore (l'upload arrive avec le back-office au module 7), donc les cartes affichent un espace reserve avec une icone — c'est normal.
- **`/dev/composants`** est une page de travail, pas une page du site : elle disparaitra ou sera neutralisee avant la mise en production (protegee par `app()->environment('local')` des maintenant par securite).
