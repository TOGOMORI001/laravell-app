# Session 04 - Défi x-page-header

`@props` déclare `title` (obligatoire) et `subtitle` (par défaut `null`) : **oui**

Le paragraphe ne s'affiche que si `subtitle` est fourni : **oui**

Le composant remplace le `h1` de `a-propos.blade.php` et de `posts/index.blade.php` : **oui**

Aucune URL écrite à la main : **oui**

Sur `/posts/archive/2025`, quel titre affiche `x-page-header`, et d'où vient-il ?

Il affiche **Articles de 2025**. `PostController::archive()` construit cette valeur dans `$heading`, puis `posts/index.blade.php` la transmet au composant avec `:title="$heading"`.
