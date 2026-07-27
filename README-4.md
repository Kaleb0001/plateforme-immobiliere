# Module 4 — Authentification publique

## Ta remarque était juste, et j'ai une remarque en retour

Ton correctif (`composer require spatie/laravel-permission` + `vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"`) est exactement la bonne solution — c'est la commande officielle qui publie la migration des tables `roles`/`permissions`. C'est moi qui aurais dû l'inclure dans le README du module 3, je l'ai oublié. Bien joué de l'avoir trouvée.

**Une chose à savoir en la corrigeant** : le message d'erreur montre `Connection: sqlite, Database: database\database.sqlite`. Tu es donc actuellement sur **SQLite**, pas PostgreSQL comme prévu dans notre stack initiale — probablement parce que Laravel 12 génère désormais un `.env` avec SQLite par défaut à l'installation, et que la copie de notre `.env.example` n'a pas écrasé le tien (le `copy` de Windows demande confirmation quand le fichier existe déjà).

Ce n'est pas grave du tout : SQLite fonctionne très bien pour développer en solo, sans serveur à installer/gérer en plus. Je pars sur **SQLite en local pour l'instant, PostgreSQL avant la mise en production** (la portabilité des migrations Laravel entre les deux est bonne ; on refera juste un `migrate:fresh` sur Postgres le moment venu). Dis-moi si tu préfères basculer sur PostgreSQL dès maintenant à la place — sinon je continue comme ça.

## Ce que contient ce module
- `app/Livewire/Auth/Register.php`, `Login.php` : composants Livewire (inscription attribue automatiquement le rôle `client`)
- `resources/views/livewire/auth/register.blade.php`, `login.blade.php` : formulaires (fonctionnels, pas encore la charte graphique définitive — ça viendra avec le design des pages publiques au module 10)
- `resources/views/account.blade.php` : page "mon compte" minimale, pour valider que l'authentification fonctionne (le vrai contenu — favoris, suivi des soumissions — arrive au module 10)
- `routes/web.php` : routes `/inscription`, `/connexion`, `/mon-compte`, `/deconnexion` (remplace le fichier existant)

## Étapes à suivre chez toi
```bash
# 1. Copier les fichiers de ce module par-dessus (en conservant l'arborescence)
#    routes/web.php REMPLACE le fichier existant ; le reste est nouveau

# 2. Rien à installer ni migrer — tout s'appuie sur ce qui existe déjà (module 3)

# 3. Lancer le projet
composer run dev
```

Vérification :
- `http://localhost:8000/inscription` → créer un compte → redirection vers `/mon-compte`
- `http://localhost:8000/connexion` → se connecter avec ce compte
- Bouton "Se déconnecter" sur `/mon-compte` → retour à l'accueil
- `php artisan tinker` puis `App\Models\User::where('email', 'ton-email-de-test')->first()->getRoleNames();` → doit contenir `client`

## Volontairement pas encore inclus
- **Réinitialisation de mot de passe** : pas dans le périmètre de ce module (nécessite la config d'un serveur mail) — je peux l'ajouter à la demande.
- **Vérification d'email** : idem, absente pour l'instant, facile à activer plus tard si tu la veux.
- **Design pixel-perfect des formulaires** : ils sont fonctionnels et utilisent déjà les tokens du design system (couleurs, rayons, ombres), mais leur mise en page détaillée suivra le travail sur les pages publiques (module 10).
