<?php

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('the welcome path renders the welcome page', function () {
    $response = $this->get('/welcome');

    $response->assertOk()->assertViewIs('welcome');
});

test('the greeting routes return their expected messages', function () {
    $this->get('/bonjour')
        ->assertOk()
        ->assertSeeText('Bonjour MDW3 ! Voici ma première route Laravel 13.');

    $this->get('/bonjour-court')
        ->assertOk()
        ->assertSeeText('Même résultat, écrit avec une fonction fléchée.');
});

test('the about page displays the student and group', function () {
    $this->get('/a-propos')
        ->assertOk()
        ->assertViewIs('a-propos')
        ->assertSeeText('Mouhib Laifi')
        ->assertSeeText('MDW32')
        ->assertSee('href="/bienvenue"', false)
        ->assertSee('href="/heure"', false);
});

test('the welcome page displays the student and course', function () {
    $this->get('/bienvenue')
        ->assertOk()
        ->assertViewIs('bienvenue')
        ->assertSeeText('Mouhib Laifi')
        ->assertSeeText('MDW32')
        ->assertSeeText('Atelier Framework Côté Serveur');
});

test('the version page displays the installed framework and PHP versions', function () {
    $this->get('/version')
        ->assertOk()
        ->assertSeeText('Laravel '.app()->version().' - PHP '.PHP_VERSION);
});

test('the time page displays the current time and date', function () {
    $this->travelTo(now()->setDate(2026, 10, 9)->setTime(15, 0));

    $this->get('/heure')
        ->assertOk()
        ->assertViewIs('heure')
        ->assertSeeText('15:00')
        ->assertSeeText('09/10/2026');
});
