# Module 6 — Assemblage de la page d'accueil

## Une decision qu'il fallait prendre pour avancer : le nom de la marque
On ne connait toujours pas le vrai nom de ta plateforme (HOFIN est celui du template, pas le tien). J'ai mis un placeholder **`VOTRE-MARQUE`** partout ou un nom de marque doit apparaitre (logo du header, wordmark du footer). C'est un rechercher/remplacer trivial des que tu me donnes le vrai nom - dis-le-moi quand tu veux, pas besoin de bloquer pour ca.

## Comment la page est construite
Plutot que de coder une page statique, j'ai branche l'assemblage sur le vrai systeme de sections du cahier des charges (module 3) : une table `pages`, des `sections` ordonnees avec un `type` et un `config` JSON. La route `/` charge la page "accueil", recupere ses sections dans l'ordre, et inclut le bon template Blade pour chacune (`resources/views/sections/{type}.blade.php`). Concretement : le contenu texte de chaque section (titres, sous-titres, etapes) vient de la base de donnees, pas de code en dur - exactement ce qu'il faut pour qu'un futur back-office (module 7) puisse le modifier sans toucher au code.

Sections assemblees, dans l'ordre de la maquette : header (integre au hero) → hero + widget de recherche → a propos → bien vedette → comment ca marche → grille "derniers biens" → grille "biens a louer" → FAQ → contact (formulaire fonctionnel) → footer.

## Ce qui est fonctionnel des maintenant
- **Formulaire de contact** : envoie reellement en base (`contact_messages`), message de confirmation affiche. Pas encore de boite de reception admin pour les lire (module 7), mais tu peux verifier via `tinker` : `App\Models\ContactMessage::all();`
- **Carte de bien interactive** : le bien marque "a la une" (Villa Horizon) s'affiche deplie par defaut, comme "Happy Lagoon Farm" sur la maquette.
- **Header** : contenu dans le hero (transparent, sur la photo) pour l'accueil ; un header simple (blanc, logo + connexion) s'affiche par defaut sur les autres pages (connexion, mon compte).

## Ce qui est volontairement simplifie pour l'instant
- **Widget de recherche** : l'interface est complete (villes/types/styles reels depuis la base), mais le bouton "Rechercher" ne mene nulle part encore - la page de resultats est prevue au module 10.
- **Photos des biens** : aucune n'existe encore (upload media = module 7), donc hero et bien vedette affichent un fond degrade / une icone a la place d'une vraie photo.
- **Navigation du bien vedette** (fleches precedent/suivant) : decorative pour l'instant, un seul bien "a la une" existe.
- **Aperçu "Comment ca marche"** : simplifie (mini recherche + 2 cartes), plutot qu'une reproduction exacte de la capture d'ecran-dans-l'ecran de la maquette.
- **Liens du menu** (Vendre/Acheter/Louer/A propos/Ressources) : pointent vers `#` en attendant que ces pages existent (module 10).

## Fichiers de ce module
- `resources/views/components/layouts/app.blade.php` — header par defaut conditionnel (remplace le fichier existant)
- `resources/views/home.blade.php` — nouveau, assemble les sections
- `resources/views/sections/*.blade.php` — 8 nouveaux templates de section
- `resources/views/components/ui/badge.blade.php` — nouvelle variante `dark` (remplace)
- `resources/views/components/ui/property-card.blade.php` — deplie par defaut si "a la une" (remplace)
- `app/Livewire/ContactForm.php` + `resources/views/livewire/contact-form.blade.php` — nouveaux
- `database/seeders/HomePageSeeder.php`, `FaqItemSeeder.php` — nouveaux
- `database/seeders/PropertyDemoSeeder.php`, `DatabaseSeeder.php` — remplaces (7 biens au lieu de 3, points d'interet ajoutes)
- `routes/web.php` — remplace (la route `/` assemble maintenant la vraie page)

## Etapes chez toi
```bash
# Copier les fichiers par-dessus (voir liste ci-dessus pour ce qui est remplace vs nouveau)

php artisan migrate:fresh --seed

# Reattribuer le role super_admin a ton compte admin (perdu par le migrate:fresh)
php artisan tinker
>>> App\Models\User::where('email', 'admin@gmail.com')->first()->assignRole('super_admin');
>>> exit

composer run dev
```

Va sur `http://localhost:8000` pour la vue d'ensemble. L'ancien fichier `resources/views/welcome.blade.php` n'est plus utilise, tu peux le laisser ou le supprimer, ca n'a pas d'impact.

Dis-moi ce qui cloche par rapport a la maquette (des captures comme les precedentes sont ideales) et le vrai nom de la marque quand tu l'auras.
