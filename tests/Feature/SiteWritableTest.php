<?php

use App\Models\Post;

beforeEach(function () {
    $this->withoutVite();
});

it('blocks post writes when the site is read-only', function () {
    config(['site.read_only' => true]);
    $post = Post::factory()->create();

    $this->put(route('posts.update', $post), [
        'title' => 'Titre modifié',
        'slug' => $post->slug,
        'body' => 'Un contenu assez long pour passer la validation.',
    ])->assertServiceUnavailable();

    expect($post->fresh()->title)->not->toBe('Titre modifié');
});

it('allows safe requests when the site is read-only', function () {
    config(['site.read_only' => true]);

    $this->get(route('posts.index'))->assertOk();
});
