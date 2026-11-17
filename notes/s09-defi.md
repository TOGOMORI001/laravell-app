# Session 09 - Défi

Le bandeau s'affiche sur toutes les pages quand SITE_READ_ONLY=true : oui
Le bandeau disparaît quand SITE_READ_ONLY=false : oui
La page Article introuvable propose au plus trois articles publiés, sans brouillon : oui
Aucune LazyLoadingViolationException sur /posts/999 : oui
Les deux nouveaux tests passent et php artisan test est vert : oui

Le bandeau est dans le layout commun pour le montrer sur toutes les pages et le maintenir à un seul endroit. Le test bascule `config(['site.read_only' => true])` uniquement pour cette requête; il ne dépend donc pas du `.env`.
