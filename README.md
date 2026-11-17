# Mini-CMS

Projet fil rouge de l'Atelier Framework Côté Serveur (Laravel 13, PHP 8.3+), 3e année MDW, ISET Sidi Bouzid.

Auteur : Mouhib Laifi, groupe MDW32.

Mini-CMS évoluera au fil du semestre vers une petite plateforme de publication : pages publiques, back-office authentifié, API JSON et tests Pest. Chaque session se termine par un tag Git (`lab-01`, puis un tag par session).

## État actuel (tag lab-04b)

- Formulaires d'article : catégorie (liste déroulante) et tags (cases à cocher, synchronisés avec `sync()`).
- Pages publiques par catégorie et par tag, liées par slug (`{category:slug}`, `{tag:slug}`).
- Accueil : catégories et tags populaires comptés avec `withCount`, articles publiés seulement.
- Tests Pest : `PostPagesTest`, `PostWriteTest`, `PostRelationsTest` et `PostTaxonomyTest`.

## Routes disponibles

| Méthode | URI | Nom | Action |
|---|---|---|---|
| GET | `/` | `home` | `PageController@home` |
| GET | `/a-propos` | `about` | `PageController@about` |
| GET | `/heure` | `time` | `PageController@time` |
| GET | `/posts` | `posts.index` | `PostController@index` |
| GET | `/posts/archive/{year}` | `posts.archive` | `PostController@archive` |
| GET | `/posts/categorie/{category:slug}` | `posts.category` | `PostController@byCategory` |
| GET | `/posts/tag/{tag:slug}` | `posts.tag` | `PostController@byTag` |
| GET | `/posts/create` | `posts.create` | `PostController@create` |
| POST | `/posts` | `posts.store` | `PostController@store` |
| GET | `/posts/{post}` | `posts.show` | `PostController@show` |
| GET | `/posts/{post}/edit` | `posts.edit` | `PostController@edit` |
| PUT | `/posts/{post}` | `posts.update` | `PostController@update` |
| DELETE | `/posts/{post}` | `posts.destroy` | `PostController@destroy` |
| PATCH | `/posts/{post}/publication` | `posts.publication` | `PostController@togglePublication` |

## Prérequis

- PHP 8.3 ou plus, avec les extensions `curl`, `fileinfo`, `mbstring`, `openssl`, `pdo_sqlite`, `sqlite3` et `zip`.
- Composer 2.
- Node.js LTS et npm.
- Git.

## Installation

### Bash (Git Bash, macOS, Linux)

```bash
git clone https://github.com/TOGOMORI001/laravell-app.git
cd laravell-app
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
composer run dev
```

### PowerShell (Windows)

```powershell
git clone https://github.com/TOGOMORI001/laravell-app.git
cd laravell-app
composer install
npm install
copy .env.example .env
php artisan key:generate
New-Item database\database.sqlite -ItemType File
php artisan migrate --seed
composer run dev
```

Ouvrir ensuite <http://localhost:8000>. L'adresse de l'application est différente de celle de Vite, qui utilise le port 5173.

> Attention : `php artisan migrate:fresh --seed` supprime toutes les tables et leurs données avant de les recréer. Utilisez-le uniquement pour réinitialiser une base de développement.

## Captures d'écran

### Page d'accueil

![Page d'accueil de Mini-CMS](screenshots/s01-accueil.png)

### Liste des routes

![Routes définies par l'application avec php artisan route:list --except-vendor](screenshots/s01-route-list.png)

### Page À propos

![Page À propos](screenshots/s02-a-propos.png)

### Accueil avec le layout

![Page d'accueil avec le layout](screenshots/s03-accueil.png)

### Liste des articles

![Liste des articles](screenshots/s03-articles.png)

### Détail d'un article

![Détail d'un article](screenshots/s03-article.png)

### Session 04

![Liste des articles](screenshots/s04-articles.png)

### Session 05

![Liste paginée des articles](screenshots/s05-articles.png)

![Formulaire avec erreurs de validation](screenshots/s05-formulaire.png)

### Session 06

![Formulaire de modification prérempli](screenshots/s06-modification.png)

![Confirmation de suppression](screenshots/s06-suppression.png)

### Session 07

![Liste des articles avec catégories, auteurs et tags](screenshots/s07-liste-relations.png)

![Détail d'un article avec tags et articles de la même catégorie](screenshots/s07-detail-tags.png)

### Session 08

![Formulaire de modification avec la catégorie et les tags](screenshots/s08-formulaire-relations.png)

![Page des articles d'une catégorie](screenshots/s08-page-categorie.png)
