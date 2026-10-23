<?php

use App\Models\Post;

beforeEach(function () {
    $this->withoutVite();
});

it('shows the posts list', function () {
    Post::create([
        'title' => 'Premier article',
        'slug' => 'premier-article',
        'body' => 'Contenu du premier article de test.',
        'is_published' => true,
        'published_at' => now(),
    ]);

    $this->get(route('posts.index'))
        ->assertOk()
        ->assertSee('Premier article');
});

it('shows a message when there is no post', function () {
    $this->get(route('posts.index'))
        ->assertOk()
        ->assertSee('Aucun article');
});

it('shows a single post', function () {
    $post = Post::create([
        'title' => 'Article complet',
        'slug' => 'article-complet',
        'body' => 'Texte complet de cet article de test.',
        'is_published' => true,
        'published_at' => now(),
    ]);

    $this->get(route('posts.show', $post))
        ->assertOk()
        ->assertSee('Texte complet de cet article de test.');
});

it('returns 404 for an unknown post', function () {
    $this->get('/posts/999')->assertNotFound();
});

it('shows the create form', function () {
    $this->get(route('posts.create'))
        ->assertOk()
        ->assertSee('Nouvel article');
});

it('returns validation errors and preserves invalid form input', function () {
    $response = $this->from(route('posts.create'))
        ->followingRedirects()
        ->post(route('posts.store'), [
            'title' => 'Titre saisi',
            'slug' => '',
            'body' => '',
        ]);

    $response
        ->assertOk()
        ->assertSee('Titre saisi')
        ->assertSee('The slug field is required.')
        ->assertSee('The body field is required.');
});

it('creates a post and redirects to its detail page', function () {
    $response = $this->post(route('posts.store'), [
        'title' => 'Article créé depuis le formulaire',
        'slug' => 'article-cree-depuis-le-formulaire',
        'body' => 'Ce contenu respecte la longueur minimale requise.',
        'is_published' => '1',
    ]);

    $post = Post::where('slug', 'article-cree-depuis-le-formulaire')->firstOrFail();

    $response->assertRedirect(route('posts.show', $post));
    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'is_published' => true,
    ]);
    expect($post->published_at)->not->toBeNull();
});

it('rejects duplicate and invalid slugs', function () {
    Post::create([
        'title' => 'Article existant',
        'slug' => 'article-existant',
        'body' => 'Contenu assez long pour respecter la validation.',
        'is_published' => false,
    ]);

    $this->from(route('posts.create'))
        ->post(route('posts.store'), [
            'title' => 'Article dupliqué',
            'slug' => 'article-existant',
            'body' => 'Contenu assez long pour respecter la validation.',
        ])
        ->assertRedirect(route('posts.create'))
        ->assertSessionHasErrors('slug');

    $this->from(route('posts.create'))
        ->post(route('posts.store'), [
            'title' => 'Slug invalide',
            'slug' => 'Slug avec espaces',
            'body' => 'Contenu assez long pour respecter la validation.',
        ])
        ->assertRedirect(route('posts.create'))
        ->assertSessionHasErrors('slug');
});

it('shows only the three most recently published posts on the home page', function () {
    foreach (range(1, 4) as $number) {
        Post::create([
            'title' => "Article publié {$number}",
            'slug' => "article-publie-{$number}",
            'body' => "Contenu publié {$number}, assez long pour être affiché.",
            'is_published' => true,
            'published_at' => now()->subDays(5 - $number),
        ]);
    }

    Post::create([
        'title' => 'Article brouillon',
        'slug' => 'article-brouillon',
        'body' => 'Un brouillon reste caché sur la page d’accueil.',
        'is_published' => false,
    ]);

    $response = $this->get(route('home'));
    $content = $response->getContent();

    $response
        ->assertOk()
        ->assertSee('Article publié 4')
        ->assertSee('Article publié 3')
        ->assertSee('Article publié 2')
        ->assertDontSee('Article publié 1')
        ->assertDontSee('Article brouillon');

    expect(substr_count($content, "Lire l'article"))->toBe(3);
});

test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
