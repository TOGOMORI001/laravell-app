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
        ->assertSee('href="/heure"', false);
});

test('the time page displays the current time and date', function () {
    $this->travelTo(now()->setDate(2026, 10, 9)->setTime(15, 0));

    $this->get('/heure')
        ->assertOk()
        ->assertViewIs('heure')
        ->assertSeeText('15:00')
        ->assertSeeText('09/10/2026');
});
