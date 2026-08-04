# Module 9 — SEO technique

## Ce qui a été ajouté

**Métadonnées par page** : titre, description, URL canonique, Open Graph et Twitter Card — tirés directement des champs `meta_title`/`meta_description` de la page (déjà dans le modèle de données depuis le module 3, maintenant réellement utilisés). L'image Open Graph utilise la photo du bien "à la une" quand elle existe.

**Données structurées (JSON-LD)** : schémas `Organization` et `WebSite` sur toutes les pages, pour que Google identifie correctement le site. Les schémas `RealEstateListing` par bien viendront naturellement avec les fiches individuelles (module 10) — pas encore de fiche bien à décrire pour l'instant.

**Sitemap et robots.txt**, générés dynamiquement (pas des fichiers statiques, donc toujours corrects quel que soit l'environnement) :
- `/sitemap.xml` — ne liste que l'accueil pour l'instant, volontairement : y ajouter des URLs de fiches biens qui n'existent pas encore (module 10) créerait des erreurs 404 pour Google. Structure prête à étendre.
- `/robots.txt` — autorise tout sauf `/admin` et `/dev`, pointe vers le sitemap.

**Performance** : chargement différé (`loading="lazy"`) sur les photos de biens et le bien vedette, qui ne sont pas visibles au premier écran — évite de ralentir l'affichage initial de la page.

## Fichiers de ce module (6 fichiers, zip)
Tous remplacent des fichiers déjà livrés.

## Étapes chez toi
```bash
composer run dev
```

Rien à migrer. Vérifie `http://localhost:8000/sitemap.xml` et `http://localhost:8000/robots.txt`, et regarde le code source de l'accueil (`Ctrl+U` dans le navigateur) pour voir les balises `<meta>` et le `<script type="application/ld+json">` en tête de page.

## Pas encore fait (normal à ce stade)
- Pas de `RealEstateListing` structuré individuel : nécessite une fiche bien (module 10)
- Pas d'image Open Graph par défaut si aucun bien n'est "à la une" — à prévoir une fois que tu auras un logo/visuel de marque
- Pas d'audit Lighthouse/Core Web Vitals formel : plus pertinent une fois le site quasi complet (prévu en fin de parcours, avec le module 11)
