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
        ->assertSee('href="http://localhost:8000"', false)
        ->assertSee('href="http://localhost:8000/a-propos"', false)
        ->assertDontSee('/bienvenue')
        ->assertSee('href="http://localhost:8000/heure"', false);
});

test('the posts page lists the static articles and shared navigation', function () {
    $this->get('/posts')
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertSeeText('Tous les articles')
        ->assertSeeText('Découvrir Laravel 13')
        ->assertSeeText('Routes et contrôleurs')
        ->assertSeeText('Premiers pas avec Blade')
        ->assertSee('href="http://localhost:8000/posts"', false);
});

test('a known post slug displays the article and a link back to the list', function () {
    $this->get('/posts/routes-et-controleurs')
        ->assertOk()
        ->assertViewIs('posts.show')
        ->assertSeeText('Routes et contrôleurs')
        ->assertSeeText('Une route associe une URL à une méthode de contrôleur.')
        ->assertSee('href="http://localhost:8000/posts"', false);
});

test('an unknown post slug returns not found', function () {
    $this->get('/posts/article-inconnu')->assertNotFound();
});

test('the article archive filters posts by year', function () {
    $this->get('/posts/archive/2025')
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertSeeText('Articles de 2025')
        ->assertSeeText('Premiers pas avec Blade')
        ->assertDontSeeText('Routes et contrôleurs');
});

test('a numeric archive year without posts renders an empty archive', function () {
    $this->get('/posts/archive/2030')
        ->assertOk()
        ->assertSeeText('Articles de 2030')
        ->assertDontSeeText('Découvrir Laravel 13')
        ->assertDontSeeText('Routes et contrôleurs')
        ->assertDontSeeText('Premiers pas avec Blade');
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
