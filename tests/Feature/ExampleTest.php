<?php

use App\Models\Post;

test('the home route renders the home page with the shared layout', function () {
    $this->get('/')
        ->assertOk()
        ->assertViewIs('home')
        ->assertSeeText('Bienvenue sur Mini-CMS')
        ->assertSeeText('Sprint en cours')
        ->assertSee('<title>Accueil - Mini-CMS</title>', false)
        ->assertSee('href="http://localhost:8000/posts"', false)
        ->assertSee('aria-current="page"', false);
});

test('the removed exercise routes return not found', function () {
    foreach (['/bonjour', '/bonjour-court', '/bienvenue', '/version', '/welcome'] as $path) {
        $this->get($path)->assertNotFound();
    }
});

test('the about page displays the student and group', function () {
    $this->get('/a-propos')
        ->assertOk()
        ->assertViewIs('a-propos')
        ->assertSeeText('Mouhib Laifi')
        ->assertSeeText('MDW32')
        ->assertSee('<title>À propos - Mini-CMS</title>', false)
        ->assertSeeText('Projet pédagogique')
        ->assertSeeText('Ce site évolue à chaque session')
        ->assertSeeText('Données en base')
        ->assertSeeText('Les articles sont enregistrés dans une base SQLite')
        ->assertSeeText('Le projet Mini-CMS et ses objectifs.')
        ->assertSee('role="status"', false)
        ->assertSee('bg-blue-50', false)
        ->assertSee('bg-green-50', false)
        ->assertSee('aria-current="page"', false)
        ->assertSee('bg-indigo-600 text-white', false)
        ->assertSee('href="http://localhost:8000"', false)
        ->assertSee('href="http://localhost:8000/a-propos"', false)
        ->assertDontSee('/bienvenue');
});

test('the posts page lists database articles and shared navigation', function () {
    $publishedAt = now()->setDate(2026, 10, 1);

    foreach ([
        ['Bienvenue sur Mini-CMS', 'bienvenue-sur-mini-cms', "Présentation du projet fil rouge de l'atelier.", true],
        ['Comprendre le routage Laravel', 'comprendre-le-routage', 'Comment une URL arrive jusqu’à un contrôleur.', true],
        ['Les composants Blade', 'les-composants-blade', 'Écrire une fois et réutiliser les composants Blade.', true],
        ['Préparer la suite du projet', 'preparer-la-suite', 'Les articles sont enregistrés dans une base.', false],
    ] as [$title, $slug, $body, $isPublished]) {
        Post::create([
            'title' => $title,
            'slug' => $slug,
            'body' => $body,
            'is_published' => $isPublished,
            'published_at' => $isPublished ? $publishedAt : null,
        ]);
    }

    $response = $this->get('/posts');

    $response
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertSeeText('Tous les articles')
        ->assertSeeText('Bienvenue sur Mini-CMS')
        ->assertSeeText('Comprendre le routage Laravel')
        ->assertSeeText('Les composants Blade')
        ->assertSeeText('Préparer la suite du projet')
        ->assertDontSeeText('Le projet Mini-CMS et ses objectifs.')
        ->assertSeeText("Présentation du projet fil rouge de l'atelier.")
        ->assertSeeText('Archive 2026')
        ->assertSee('href="http://localhost:8000/posts"', false);

    expect(substr_count($response->getContent(), 'Brouillon'))->toBe(1);
});

test('a known post id displays the article and a link back to the list', function () {
    $post = Post::create([
        'title' => 'Comprendre le routage Laravel',
        'slug' => 'comprendre-le-routage',
        'body' => "Une route associe une URL à une action.\nLes paramètres sont transmis au contrôleur.",
        'is_published' => true,
        'published_at' => now()->setDate(2026, 10, 3),
    ]);

    $this->get(route('posts.show', $post))
        ->assertOk()
        ->assertViewIs('posts.show')
        ->assertSeeText('Comprendre le routage Laravel')
        ->assertSeeText('03/10/2026')
        ->assertSeeText('Une route associe une URL à une action.')
        ->assertSeeText('Les paramètres sont transmis au contrôleur.')
        ->assertSeeText('Retour aux articles')
        ->assertSee('aria-current="page"', false)
        ->assertSee('bg-indigo-600 text-white', false)
        ->assertSee('href="http://localhost:8000/posts"', false);
});

test('an unknown post id returns not found', function () {
    $this->get('/posts/999')->assertNotFound();
});

test('the article archive filters posts by year', function () {
    Post::create([
        'title' => 'Publié en 2026',
        'slug' => 'publie-en-2026',
        'body' => 'Article publié pendant l’année 2026.',
        'is_published' => true,
        'published_at' => now()->setDate(2026, 10, 8),
    ]);
    Post::create([
        'title' => 'Brouillon',
        'slug' => 'brouillon-archive',
        'body' => 'Cet article ne doit pas apparaître dans les archives.',
        'is_published' => false,
    ]);

    $this->get('/posts/archive/2026')
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertSeeText('Articles de 2026')
        ->assertSeeText('Publié en 2026')
        ->assertDontSeeText('Brouillon');
});

test('a numeric archive year without posts renders an empty archive', function () {
    $this->get('/posts/archive/2025')
        ->assertOk()
        ->assertSeeText('Articles de 2025')
        ->assertDontSeeText('Le projet Mini-CMS et ses objectifs.')
        ->assertSeeText('Aucun article')
        ->assertSeeText("Il n'y a pas encore d'article.")
        ->assertSee('border-amber-500', false)
        ->assertDontSeeText('Bienvenue sur Mini-CMS')
        ->assertDontSeeText('Comprendre le routage Laravel')
        ->assertDontSeeText('Les composants Blade')
        ->assertDontSeeText('Préparer la suite du projet');
});

test('invalid archive years and post slugs return not found', function () {
    $this->get('/posts/archive/abc')->assertNotFound();
    $this->get('/posts/Article')->assertNotFound();
});

test('the time page displays the current time and date', function () {
    $this->travelTo(now()->setDate(2026, 10, 9)->setTime(15, 0));

    $this->get('/heure')
        ->assertOk()
        ->assertViewIs('heure')
        ->assertSeeText('15:00')
        ->assertSeeText('09/10/2026')
        ->assertSee('<title>Heure du serveur - Mini-CMS</title>', false)
        ->assertSee('href="http://localhost:8000/heure"', false)
        ->assertSee('aria-current="page"', false)
        ->assertSee('bg-indigo-600 text-white', false);
});
