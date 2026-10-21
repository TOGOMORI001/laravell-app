<?php

test('the home route renders the welcome page', function () {
    $this->get('/')
        ->assertOk()
        ->assertViewIs('welcome');
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
        ->assertSee('href="http://localhost:8000"', false)
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
