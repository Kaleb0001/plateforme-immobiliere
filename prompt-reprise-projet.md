# Reprise de projet — Plateforme immobilière (contexte complet)

Tu (Claude) reprends un projet déjà bien avancé. Ce document te donne tout le contexte nécessaire pour continuer sans perte d'information. Lis-le entièrement avant de répondre à l'utilisateur, puis attends ses instructions pour la suite (ne redémarre pas le projet depuis le début).

## Rôle attendu
Agis en ingénieur logiciel senior (15+ ans d'expérience), objectif et direct. Réponds en français. Vérifie les versions actuelles des packages/frameworks avant de fournir du code plutôt que de te fier à ta mémoire d'entraînement — plusieurs erreurs de version ont déjà eu lieu sur ce projet (Laravel, Filament) et ont dû être corrigées après coup.

## Vision du projet
Plateforme immobilière sur-mesure, priorité absolue au SEO ("la mieux référencée du secteur"), back-office très flexible (l'admin publie des biens, gère l'intégralité du contenu public, compose les pages par sections modulables sans toucher au code). C'est aussi une marketplace à modération : un visiteur peut créer un compte, sauvegarder des favoris, et soumettre un bien à vendre/louer via un formulaire allégé ; un admin valide (en assignant un agent) ou refuse (avec motif) avant publication publique.

Une maquette (style "HOFIN", en anglais) a été fournie pour la page d'accueil uniquement. Toutes les pages doivent s'aligner pixel-perfect sur son design system ; les pages non couvertes par la maquette sont conçues par l'assistant en cohérence avec ce design system. Le contenu du site est entièrement en français. Le nom de marque réel n'a jamais été communiqué — un placeholder **`VOTRE-MARQUE`** est utilisé partout (logo, footer, meta), à remplacer par recherche/remplacer une fois connu.

## Stack technique (validée et confirmée fonctionnelle)
- **Laravel 12** (pas 11 — obsolète ; pas 13 — nécessite PHP 8.3+ que l'environnement de l'utilisateur n'a pas)
- **PHP 8.2.12** — contrainte dure de l'environnement local (XAMPP sur Windows, chemin projet sous `F:\Projets\...`, PHP dans `C:\xampp\php\`) ; l'utilisateur ne veut pas upgrader pour l'instant
- **Filament v4** pour le back-office. Points d'API confirmés par l'expérience réelle (pas une supposition) :
  - Les Resources génèrent des classes séparées : `Schemas/{Model}Form.php` (méthode `configure(Schema $schema): Schema`, retourne `$schema->components([...])`) et `Tables/{Model}sTable.php` (méthode `configure(Table $table): Table`)
  - Les actions de table s'appellent `->recordActions([...])` et `->toolbarActions([...])` (pas `->actions()`/`->bulkActions()`)
  - Namespace des actions : `Filament\Actions\*` (pas `Filament\Tables\Actions\*`)
  - Les actions avec formulaire modal utilisent `->schema([...])` (pas `->form([...])`)
  - Les closures `Get`/`Set` viennent de `Filament\Schemas\Components\Utilities\{Get,Set}` — par prudence, le code du projet utilise des closures non typées (`fn ($get) => ...`) pour éviter ce risque de namespace
  - Media : `filament/spatie-laravel-media-library-plugin:"^4.0"`, composant `Filament\Forms\Components\SpatieMediaLibraryFileUpload`
- **Livewire v3** (pas v4 — trop récent, sorti après la coupure de connaissances de l'assistant, moins de certitude sur son API)
- **Tailwind v4** (config CSS-first via `@theme` dans `resources/css/theme.css`)
- **Base de données : SQLite en local actuellement** (`database/database.sqlite`), pas PostgreSQL comme prévu initialement — probablement un `.env` par défaut de Laravel 12 jamais écrasé. Décision actée : SQLite en dev, PostgreSQL avant la mise en production (migration à refaire à ce moment-là)
- `spatie/laravel-permission` (rôles : `super_admin`, `admin`, `agent`, `client`)
- `spatie/laravel-medialibrary` (galeries photos des biens, collection `gallery`)
- `spatie/laravel-sluggable` **v3 uniquement** (la v4 exige PHP 8.3+, incompatible avec l'environnement)
- `laravel-lang/common` (traductions FR des messages Laravel natifs)
- Police : **General Sans** (Fontshare, gratuite), chargée via `<link>` dans le layout
- Devise affichée : **€** par défaut (placeholder, la devise cible réelle n'a jamais été confirmée)

## Design system (extrait par analyse de pixels de la maquette fournie)
- Fond réel : `#FFFFFF` (le gris autour de la maquette n'était qu'un cadre de présentation d'export, pas le vrai design)
- Couleur "ink" (texte principal, CTA noirs, sections sombres) : `#242424`
- Texte secondaire : `#6B6B6B`
- Bordures/séparateurs : `#E5E5E5`
- Rayons : cartes/widgets ~20px (`--radius-card`), champs ~12px (`--radius-field`), boutons/badges en pilule complète (`--radius-pill`)
- Ombres douces et discrètes
- Aucune couleur d'accent dédiée dans l'UI — la couleur vient uniquement de la photographie
- Tokens centralisés dans `resources/css/theme.css` (variables CSS `--color-*`, `--radius-*`, `--shadow-card`, `--text-*`)

## Modèle de données
- **User** (`HasRoles`, `FilamentUser` avec `canAccessPanel()` limité à `super_admin`/`admin`) : name, email, phone, password. Relations : `favoriteProperties` (belongsToMany Property via `favorites`), `submittedProperties` (hasMany Property via `submitted_by`), `assignedProperties` (hasMany Property via `assigned_agent_id`)
- **Property** (`HasSlug`, `InteractsWithMedia`, `Searchable` via Scout) : title, slug, description, transaction_type (enum), property_type_id/property_style_id/city_id (FK), price, address, latitude/longitude, surface, bedrooms, bathrooms, status (enum), featured (bool), points_of_interest (JSON : `[{label, position}]`), submitted_by, assigned_agent_id, rejection_reason, meta_title, meta_description, published_at
- **City, PropertyType, PropertyStyle** : taxonomies simples (name, slug), gérées comme tables pour permettre futures pages SEO par ville/type
- **Favorite** : table pivot (user_id, property_id)
- **ContactMessage** : name, email, message, status (enum)
- **FaqItem** : question, answer, order, published
- **Page** (slug, meta_title, meta_description) → **Section** (hasMany, ordonnées) : type (enum), order, config (JSON, structure différente par type), visible — c'est le système de CMS qui rend la page d'accueil dynamique
- **Enums PHP natifs (8.1+, stockés en string)** : `TransactionType` (vente/location), `PropertyStatus` (brouillon/en_attente_validation/publie/refuse/vendu/loue), `ContactMessageStatus` (non_lu/lu/traite), `SectionType` (hero/about/featured_showcase/how_it_works/property_grid/faq/contact/footer/html_libre) — chacun a une méthode `label()`

## Architecture
Monolithe Laravel/Filament/Livewire, un seul dépôt. Site public en Blade/Livewire (SSR natif, bon pour le SEO), back-office en Filament (`/admin`). La page d'accueil n'est **pas** codée en dur : la route `/` charge la `Page` "accueil" et boucle sur ses `Section` ordonnées, incluant `resources/views/sections/{type}.blade.php` pour chacune avec son `config` JSON — exactement le système de CMS flexible visé dès le cahier des charges initial. Le back-office pilote ces sections via `SectionsRelationManager` sur `PageResource` (champs conditionnels selon le type sélectionné).

Workflow de modération : client soumet (`/proposer-un-bien`, statut `en_attente_validation`) → admin voit la file dans `/admin/properties` → **Approuver** (assigne un agent, statut `publie`) ou **Refuser** (motif requis, statut `refuse`) via des actions Filament dédiées.

## Ce qui est déjà construit (modules 1 à 10, tous livrés et testés par l'utilisateur)
1. **Design system** extrait de la maquette (tokens CSS)
2. **Fondations** Laravel/Filament/Livewire, i18n FR
3. **Modèle de données** complet (migrations, modèles, enums, seeders de rôles/taxonomies)
4. **Authentification publique** (inscription/connexion Livewire, rôle `client` auto-assigné)
5. **Composants UI réutilisables** : `x-ui.property-card` (carte interactive repliée/dépliée photo↔description, dépliée par défaut si `featured`), `x-ui.badge` (eyebrow + variante `dark`), `x-ui.floating-tag` (pilule + point, pour badges sur photo), `x-ui.carousel`, `x-ui.accordion`/`accordion-item` (bouton toujours bordé, chevron pivote), `x-ui.intro-card`, `x-ui.icon` (SVG centralisés), `x-form.input`/`select`/`button` (fond gris uni sans bordure, bouton avec flèche `↗` intégrée), directive Alpine `x-reveal` (apparition au scroll), plugin `@alpinejs/collapse`
6. **Page d'accueil assemblée** via le système de sections (hero avec widget de recherche fonctionnel, à propos, bien vedette avec badges de points d'intérêt, comment ça marche, 2 grilles de biens, FAQ, contact fonctionnel, footer)
7. **Back-office Filament** : `PropertyResource` (CRUD complet + actions Approuver/Refuser + upload photos), `FaqItemResource`, `ContactMessageResource` (+ action "marquer traité"), `PageResource` avec `SectionsRelationManager`
8. **Animations/transitions** : en-tête flottant qui apparaît au scroll sur l'accueil, en-tête sticky ailleurs, hover sur cartes/boutons/liens
9. **SEO technique** : meta title/description/OG/Twitter par page, JSON-LD (Organization/WebSite en global, RealEstateListing par bien), sitemap.xml et robots.txt dynamiques, lazy loading des images hors premier écran
10. **Pages publiques suivantes** : recherche/résultats (`/biens`, filtres Livewire réactifs, pagination), fiche bien (`/biens/{slug}`, galerie, caractéristiques, agent, biens similaires, favoris fonctionnels), espace client (`/mon-compte`, favoris + suivi des soumissions), formulaire de soumission de bien (`/proposer-un-bien`, avec upload photos), page À propos (structure prête, contenu placeholder `[À compléter]`). Tous les liens de navigation (menu, footer) pointent vers de vraies pages.

## Audit et optimisation (session du 03/08/2026)

Un audit complet du code (modèles, migrations, Filament, Livewire, Blade, CSS, config, seeders, base SQLite fournie) a été réalisé et une large série de corrections appliquée directement dans le code. Détail complet dans la conversation ; résumé ci-dessous.

**Diagnostic clé (photos invisibles) :** le lien symbolique `public/storage` n'existe très probablement pas sur la machine locale (Windows/XAMPP). Les fichiers sont bien présents sur disque (`storage/app/public/{id}/...`), mais sans ce lien, l'URL `/storage/...` renvoie un 404. **Action manuelle requise, à faire en priorité :**
```
php artisan storage:link
```
Sur Windows, si la commande échoue silencieusement : activer le Mode développeur (Paramètres > Confidentialité et sécurité > Pour les développeurs) OU lancer l'invite de commandes/PowerShell en Administrateur, puis relancer la commande.

**Corrigé :**
- `.env`/`.env.example` en anglais (`APP_LOCALE=en`, `APP_NAME=Laravel`) malgré des défauts FR déjà prévus dans `config/app.php` → tous les messages Laravel natifs (validation, etc.) s'affichaient en anglais, et le `<title>`/OG/JSON-LD affichaient "Laravel". Corrigé en `fr` / `VOTRE-MARQUE`. Toutes les occurrences codées en dur de "VOTRE-MARQUE" dans les vues remplacées par `config('app.name')` (un seul endroit à changer le jour où le vrai nom sera connu).
- Fuseau horaire figé en UTC → `Europe/Paris`.
- Scout installé sans pilote configuré (jobs de synchronisation voués à l'échec, recherche publique n'utilisant de toute façon que des filtres Eloquent) → pilote `database` activé (natif, zéro service externe) + recherche par mot-clé réellement branchée sur `/biens`.
- `[x-cloak]` utilisé sans la règle CSS correspondante (ne masquait rien) → règle ajoutée, avec au passage le respect de `prefers-reduced-motion`.
- Seeder de démo (`PropertyDemoSeeder`) dépendant d'un accès internet (`addMediaFromUrl` vers picsum.photos, source probable d'échecs silencieux sur XAMPP/Windows : pare-feu, proxy, certificat SSL obsolète) → remplacé par une génération locale d'images (GD, dégradé + silhouette), zéro dépendance réseau. Même mécanisme utilisé pour une photo de fond de démonstration du hero.
- Aucune limitation de débit sur les 4 formulaires publics malgré l'exigence explicite du cahier des charges (§8) → ajoutée sur connexion, inscription, contact, soumission de bien.
- Requêtes N+1 (pas d'eager loading `city`/`media`) sur l'accueil, la recherche, la fiche bien, l'espace client → corrigées.
- Aucune conversion d'image (WebP, tailles responsives) malgré l'exigence SEO explicite → ajoutées sur `Property` (conversions `card`/`detail`) et `Section` (conversion `banner`), avec repli gracieux sur l'original si la conversion n'existe pas.
- Fiche bien détaillée n'affichait que la 1ère photo malgré une galerie multi-photos → galerie complète (carousel plein écran).
- Bloc "bien vedette" de l'accueil : flèches précédent/suivant décoratives, sans aucun effet (un seul bien chargé) → transformé en vrai mini-carousel sur plusieurs biens vedettes.
- Aucune navigation mobile nulle part (hero, header flottant, header générique : liens en `hidden lg:flex` sans alternative) → composant `<x-layouts.site-nav>` unique (menu desktop + menu mobile plein écran), qui élimine aussi la triple duplication du header.
- Photo de fond du hero jamais branchée malgré la médiathèque déjà en place (`Section` n'avait pas `InteractsWithMedia`) → ajoutée, éditable depuis l'admin, avec repli en dégradé.
- Grand moment de marque du footer (wordmark géant + photo), présent dans la maquette mais absent de l'implémentation → ajouté.
- Champs manquants dans l'admin pour éditer le footer (liens de nav/réseaux sociaux) et les badges du hero (`tag_1`/`tag_2`) → modifiables uniquement en base brute jusqu'ici → champs Filament ajoutés (repeaters + text inputs).
- Message de contact reste "non lu" indéfiniment jusqu'à une action manuelle → passe automatiquement à "lu" à l'ouverture.
- Upload photos admin sans limite de taille (incohérent avec le formulaire public à 5 Mo) → `maxSize` ajouté, défense en profondeur.
- Liens du footer seedés en URLs absolues figées au moment du seed (non portables si le domaine change) → chemins relatifs.

**Repéré mais volontairement laissé de côté (scope raisonnable) :**
- Panneau décoratif "comment ça marche" (recherche non fonctionnelle) : auto-documenté comme un aperçu simplifié dans le code d'origine, non traité par cohérence de périmètre.
- Vraie recherche typo-tolérante (Meilisearch) : nécessite un serveur Meilisearch réellement déployé ; le pilote `database` est une amélioration immédiate sans infrastructure supplémentaire, à remplacer en prod.

**Toujours en attente (inchangé) :**
- Nom de marque réel jamais communiqué (`VOTRE-MARQUE`).
- Contenu de la page À propos toujours `[À compléter]`.
- Gestion des agents toujours via `php artisan tinker`.
- Devise (€) jamais confirmée.
- Migration PostgreSQL avant mise en production.

---



## Méthode de travail à respecter
- Avancer **module par module** : poser les questions de clarification nécessaires avant de commencer un module (mais sans excès — l'utilisateur fait confiance au jugement de l'assistant sur les détails d'exécution), livrer, l'utilisateur teste chez lui et valide avant de passer au suivant.
- **Livraison en fichier zip** à la fin de chaque module/partie, **sauf si moins de 5 fichiers** ou si l'assistant juge un zip inutile (dans ce cas, code donné directement dans le chat).
- L'assistant n'a pas accès réseau dans son environnement d'exécution — il ne peut pas lancer `composer install`/`npm install` lui-même ; il fournit les commandes exactes à exécuter côté utilisateur.
- Toujours vérifier les versions actuelles (recherche web) avant de fournir du code pour un framework/package à évolution rapide (Laravel, Filament) plutôt que de se fier à la mémoire d'entraînement — plusieurs corrections ont déjà été nécessaires sur ce projet suite à des versions obsolètes fournies par erreur.
- Ce prompt de reprise n'est fourni qu'à la demande explicite de l'utilisateur, pas automatiquement à chaque module.

## Prochaine étape (là où on s'est arrêté)

La revue générale des remarques et améliorations mises de côté a été faite (voir section Audit ci-dessus). Il reste :
1. **Action manuelle immédiate côté utilisateur** : `php artisan storage:link` (voir diagnostic ci-dessus), puis réinstaller/rafraîchir les dépendances si besoin (`composer install`, `npm install && npm run build`) et rejouer les seeders (`php artisan migrate:fresh --seed`) pour bénéficier des nouvelles photos générées localement et des nouveaux champs de section.
2. **Module 11** : tests, QA responsive/accessibilité, déploiement.

Demander à l'utilisateur s'il a bien pu vérifier l'affichage des photos après `storage:link`, avant d'enchaîner sur le module 11.
