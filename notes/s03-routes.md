# Session 03 - Routes, contrôleurs et layout

Réponses rédigées avec mes propres mots.

URL produite par `route('about')` :

`http://localhost:8000/a-propos`

URL produite par `route('posts.show', 'routes-et-controleurs')` :

`http://localhost:8000/posts/routes-et-controleurs`

URL produite par `route('posts.archive', 2025)` :

`http://localhost:8000/posts/archive/2025`

Pourquoi `/posts/archive/abc` et `/posts/article-inconnu` répondent toutes deux 404, et quelle ligne de code en est responsable dans chaque cas ?

`/posts/archive/abc` ne correspond pas à la contrainte `whereNumber('year')` déclarée sur la route d'archive. `/posts/article-inconnu` correspond à la route d'article, mais `PostController::show()` appelle `abort(404)` lorsque le slug n'existe pas dans la liste.

Que se passe-t-il si une vue appelle `route('posts.show')` sans paramètre ?

Laravel lève une `UrlGenerationException`, car la route `posts.show` exige le paramètre `slug` pour construire son URL.
