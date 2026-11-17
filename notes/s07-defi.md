# Session 07 - Défi : articles de la même catégorie

La section « Dans la même catégorie » apparaît sous un article publié qui a une catégorie : oui
L'article affiché n'apparaît pas dans sa propre section : oui
Un brouillon de la même catégorie n'apparaît pas : oui
La page s'ouvre sans LazyLoadingViolationException : oui
Le nouveau test passe et php artisan test est vert : oui

La section exécute quatre requêtes : une pour les articles associés, puis une pour chaque relation eager-loadée (auteur, catégorie et tags). `with()` regroupe chaque relation en une requête, au lieu de déclencher une requête par carte.
