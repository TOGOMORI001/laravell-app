<?php

use App\Models\Post;

beforeEach(function () {
    $this->withoutVite();
});

function feedbackPostData(array $overrides = []): array
{
    return array_merge([
        'title' => 'Article avec message',
        'slug' => 'article-avec-message',
        'body' => 'Contenu assez long pour passer la validation.',
        'is_published' => '1',
    ], $overrides);
}

it('shows a success message after creating a post', function () {
    $this->followingRedirects()
        ->post(route('posts.store'), feedbackPostData())
        ->assertOk()
        ->assertSee('Article créé.');
});

it('shows a success message after updating a post', function () {
    $post = Post::factory()->create();

    $this->followingRedirects()
        ->put(route('posts.update', $post), [
            'title' => 'Article modifié',
            'slug' => $post->slug,
            'body' => 'Un contenu assez long pour passer la validation.',
        ])
        ->assertOk()
        ->assertSee('Article mis à jour.');
});

it('shows a success message after toggling publication', function () {
    $post = Post::factory()->create();

    $this->followingRedirects()
        ->patch(route('posts.publication', $post))
        ->assertOk()
        ->assertSee('Article publié.');
});

it('shows a success message after deleting a post', function () {
    $post = Post::factory()->create();

    $this->followingRedirects()
        ->delete(route('posts.destroy', $post))
        ->assertOk()
        ->assertSee('Article supprimé.');
});

it('shows the custom page for an unknown post', function () {
    $this->get('/posts/999')
        ->assertNotFound()
        ->assertSee('Article introuvable');
});

it('keeps the standard 404 page for an unknown category', function () {
    $this->get('/posts/categorie/inconnue')
        ->assertNotFound()
        ->assertDontSee('Article introuvable');
});

it('shows the read-only banner when the site is read-only', function () {
    config(['site.read_only' => true]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Site en lecture seule');
});

it('shows recent published posts but no drafts on the custom not-found page', function () {
    Post::factory()->published()->create(['title' => 'Article récent publié']);
    Post::factory()->create(['title' => 'Article récent brouillon']);

    $this->get('/posts/999')
        ->assertNotFound()
        ->assertSee('Article récent publié')
        ->assertDontSee('Article récent brouillon');
});
