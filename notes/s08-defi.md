# Session 08 - Défi

`/posts/tag/<slug>` liste uniquement les articles publiés, quatre par page : oui
Les tags des cartes ouvrent leur page publique : oui
L'accueil affiche les tags ayant des articles publiés, triés par nombre décroissant : oui
Le nombre affiché pour chaque catégorie/tag compte seulement les articles publiés : oui
Les trois tests du défi passent avec `php artisan test` : oui

Les pages par tag et par catégorie utilisent les relations Eloquent avec eager loading. `withCount` ne charge pas les articles associés : la base calcule le nombre de publications et le passe dans `posts_count`.
