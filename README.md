# Révision des composants UI — fidélité à la maquette

Tu avais raison, la première passe était trop générique. J'ai zoomé précisément sur tes nouvelles captures (carte avec agent, FAQ, formulaire de contact, badges du hero) pour corriger la structure exacte plutôt que de réinterpréter approximativement. Voici ce qui change et pourquoi.

## Ce qui a été corrigé

**Carte de bien** — la vraie structure est : photo (coins arrondis en haut), cœur favori en cercle blanc semi-transparent en haut à droite, puis un bloc texte avec : titre + petit bouton carré bordé contenant une flèche (↗), ville avec icône de repère, et une dernière ligne prix/agent. Ma première version mettait tout dans un seul bloc sans cette hiérarchie — corrigé.

**Carte "mise en avant"** (ex. Happy Lagoon Farm) — fond sombre uni, icône marque-page (pas cœur) en haut à droite, description, prix. C'est une vraie variante visuelle, pas juste une carte avec plus de texte — j'ai séparé ça proprement (`variant="description"`).

**Badges flottants sur photo** (Buy Property, Balcony 2nd Floor...) — j'avais oublié le petit point noir accolé à la pilule, visible sur toutes tes captures. Nouveau composant `x-ui.floating-tag` dédié à ce motif, séparé des badges "étiquette de section" (ABOUT, EXPLORE...) qui eux restent de simples pilules sans point.

**FAQ** — chaque question a un numéro ("01", "02"...) et le chevron n'est dans un bouton bordé que lorsque la question est ouverte (fermé = icône seule). Corrigé.

**Champs de formulaire** — sur ta capture du formulaire de contact, les champs ont un fond gris clair uni, sans bordure visible — pas le style bordé que j'avais mis. Corrigé sur `x-form.input` et `x-form.select`.

**Boutons** — "Search ↗", "Send ↗" : la flèche fait partie du bouton lui-même, pas du texte. `x-form.button` l'ajoute maintenant automatiquement (désactivable avec `:icon="false"`).

**Nouveau composant `x-ui.icon`** : centralise les icônes SVG utilisées partout (cœur, marque-page, flèche, repère, photo, chevron) pour ne pas les dupliquer dans chaque composant.

**Nouveau composant `x-ui.intro-card`** : le bloc texte "Fresh Opportunities" qui s'intercale dans la grille de biens.

J'ai aussi mis à jour les formulaires de connexion/inscription (module 4) pour utiliser ces mêmes composants — tout est maintenant cohérent.

## Point que je ne peux pas deviner — ta décision nécessaire

Sur la page "Buy Property" (ta capture avec la carte), chaque bien affiche un agent avec avatar, nom **et une note (4.5 Review)**. Ça n'existe pas dans notre modèle de données actuel — on n'a jamais prévu de système d'avis/notation, ni sur les agents ni sur les biens. Deux options :
- **Simple** : on affiche juste le nom de l'agent assigné, sans note (ce que j'ai fait pour l'instant, en attendant ta réponse)
- **Complet** : on ajoute un vrai système de notation (nouvelle table, logique métier, source des avis à définir) — un ajout non négligeable au périmètre initial

Dis-moi ce que tu préfères, ça n'a pas besoin d'être tranché maintenant.

## Etapes a suivre chez toi
```bash
# Copier les fichiers par-dessus (tous remplacent des fichiers du module 5,
# sauf icon.blade.php, floating-tag.blade.php et intro-card.blade.php qui sont nouveaux)

composer run dev
```

Vérifie `/dev/composants` — nouvelle vitrine avec la carte "mise en avant", la carte d'intro, et les badges flottants sur fond sombre pour bien voir le contraste.
