# Module 10, partie 1 — Fiche bien

Module 10 couvre 4 pages (recherche/listing, fiche bien, espace client, à propos). Je commence par la fiche bien : c'est la fondation dont les autres dépendent (les cartes y renvoient déjà, le sitemap et les données structurées en avaient besoin).

## Ce que contient cette livraison

**Page fiche bien** (`/biens/{slug}`) : fil d'ariane, galerie (photo + badges de points d'intérêt), titre/localisation/prix, caractéristiques (transaction, type, surface, chambres), description complète, encart agent avec lien mailto si un agent est assigné, biens similaires (même ville). Données structurées `RealEstateListing` incluses.

**Favoris enfin fonctionnels** : le cœur sur les cartes et sur la fiche bien fonctionne réellement maintenant (`FavoriteButton`, composant Livewire réutilisable) — un visiteur non connecté est redirigé vers la connexion, un utilisateur connecté peut ajouter/retirer un bien de ses favoris.

**Cartes de biens cliquables** : la photo et le titre renvoient maintenant vers la fiche complète (le chevron continue de faire basculer l'aperçu description, comme avant).

**Sitemap étendu** : `/sitemap.xml` liste maintenant aussi tous les biens publiés, en plus de l'accueil — ce qu'on avait volontairement reporté au module 9.

## Fichiers (8 fichiers, zip)
- `app/Livewire/FavoriteButton.php`, `resources/views/livewire/favorite-button.blade.php` — nouveaux
- `resources/views/properties/show.blade.php` — nouveau
- `resources/views/components/ui/property-card.blade.php` — remplace (liens + favoris)
- `routes/web.php` — remplace (route fiche bien + sitemap étendu)

## Étapes chez toi
```bash
composer run dev
```

Rien à migrer. Clique sur une carte de bien depuis l'accueil pour arriver sur sa fiche, teste le cœur (connecté et déconnecté), et regarde `/sitemap.xml` pour confirmer que les biens y apparaissent.

## Prochaine partie du module 10
Recherche/listing (page de résultats que le widget de recherche de l'accueil pourra enfin cibler), puis espace client (favoris + suivi des soumissions), puis à propos. Dis-moi quand tu es prêt à continuer, ou si tu veux d'abord valider cette fiche bien.
