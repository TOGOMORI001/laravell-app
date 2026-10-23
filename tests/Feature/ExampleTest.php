<?php

test('the home route renders the home page with the shared layout', function () {
    $this->get('/')
        ->assertOk()
        ->assertViewIs('home')
        ->assertSeeText('Bienvenue sur Mini-CMS')
        ->assertSee('<title>Accueil - Mini-CMS</title>', false)
        ->assertSee('href="http://localhost:8000/a-propos"', false);
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
        ->assertSeeText('Données provisoires')
        ->assertSeeText("Les articles affichés viennent d'un tableau PHP")
        ->assertSee('role="status"', false)
        ->assertSee('bg-blue-50', false)
        ->assertSee('bg-amber-50', false)
        ->assertSee('href="http://localhost:8000"', false)
        ->assertSee('href="http://localhost:8000/a-propos"', false)
        ->assertDontSee('/bienvenue');
});

test('the posts page lists the static articles and shared navigation', function () {
    $this->get('/posts')
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertSeeText('Tous les articles')
        ->assertSeeText('Bienvenue sur Mini-CMS')
        ->assertSeeText('Comprendre le routage Laravel')
        ->assertSeeText('Les composants Blade')
        ->assertSeeText('Préparer la suite du projet')
        ->assertSee('href="http://localhost:8000/posts"', false);
});

test('a known post slug displays the article and a link back to the list', function () {
    $this->get('/posts/comprendre-le-routage')
        ->assertOk()
        ->assertViewIs('posts.show')
        ->assertSeeText('Comprendre le routage Laravel')
        ->assertSeeText('Une route associe une URL à une action.')
        ->assertSeeText('Les paramètres, comme le slug d’un article')
        ->assertSee('href="http://localhost:8000/posts"', false);
});

test('an unknown post slug returns not found', function () {
    $this->get('/posts/article-inconnu')->assertNotFound();
});

test('the article archive filters posts by year', function () {
    $this->get('/posts/archive/2026')
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertSeeText('Articles de 2026')
        ->assertSeeText('Bienvenue sur Mini-CMS')
        ->assertSeeText('Préparer la suite du projet');
});

test('a numeric archive year without posts renders an empty archive', function () {
    $this->get('/posts/archive/2030')
        ->assertOk()
        ->assertSeeText('Articles de 2030')
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
        ->assertSee('href="http://localhost:8000/heure"', false);
});
