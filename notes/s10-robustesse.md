# Session 10 - Robustesse

TagAdminTest contient 5 tests verts : oui
/posts/categorie/inconnue affiche Catégorie introuvable avec le statut 404 : oui
php artisan test est vert : oui

1. Pourquoi le message de messages() l'emporte-t-il sur celui de lang/fr/validation.php ?

Laravel cherche d'abord le message défini pour cette règle et ce champ dans la Form Request. Le fichier de langue ne fournit le message que si aucun message plus précis n'existe.

2. Pourquoi phpunit.xml fixe-t-il APP_LOCALE ?

Les tests comparent des messages en français. Fixer la locale dans phpunit.xml garantit le même résultat sur chaque poste et sur un clone propre, indépendamment du fichier .env local.

3. Pourquoi CategoryController n'a-t-il besoin d'aucun try/catch ?

La Form Request bloque les données invalides avant l'appel du contrôleur, la liaison de modèle répond 404 pour une catégorie inconnue, et le middleware répond 503 en lecture seule. Le gestionnaire d'exceptions rend ces erreurs ; le contrôleur n'a rien à récupérer avec un try/catch.
