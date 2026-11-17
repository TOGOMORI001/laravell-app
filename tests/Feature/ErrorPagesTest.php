<?php

use App\Models\Category;

beforeEach(function () {
    $this->withoutVite();
});

it('shows the styled 404 page for an unknown URL', function () {
    $this->get('/page-inexistante')
        ->assertNotFound()
        ->assertSee('Page introuvable')
        ->assertSee("Retour à l'accueil", false);
});

it('shows the styled 503 page when the site is read-only', function () {
    config(['site.read_only' => true]);

    $this->post(route('posts.store'), [])
        ->assertStatus(503)
        ->assertSee('Service momentanément indisponible')
        ->assertSee('Le site est en lecture seule.')
        ->assertSee("Retour à l'accueil", false);
});

it('shows available categories when a category slug is unknown', function () {
    $category = Category::factory()->create(['name' => 'Laravel', 'slug' => 'laravel']);

    $this->get(route('posts.category', ['category' => 'inconnue']))
        ->assertNotFound()
        ->assertSee('Catégorie introuvable')
        ->assertSee('Laravel')
        ->assertSee(route('posts.category', ['category' => $category->slug]), false);
});

it('keeps API not-found responses in JSON', function () {
    $this->getJson('/api/route-inexistante')
        ->assertNotFound()
        ->assertJsonStructure(['message']);
});

it('keeps missing post responses in JSON for JSON requests', function () {
    $this->getJson('/posts/999')
        ->assertNotFound()
        ->assertJsonStructure(['message'])
        ->assertJsonMissing(['message' => 'Article introuvable']);
});
