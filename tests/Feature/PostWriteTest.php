<?php

use App\Models\Post;

beforeEach(function () {
    $this->withoutVite();
});

function postData(array $overrides = []): array
{
    return array_merge([
        'title' => 'Article de test',
        'slug' => 'article-de-test',
        'excerpt' => 'Un extrait court.',
        'body' => 'Contenu assez long pour passer la validation.',
        'is_published' => '0',
    ], $overrides);
}

it('creates a post from the form', function () {
    $this->post(route('posts.store'), postData())
        ->assertRedirect();

    $this->assertDatabaseHas('posts', [
        'title' => 'Article de test',
        'slug' => 'article-de-test',
        'excerpt' => 'Un extrait court.',
    ]);
});

it('does not create a post without a title', function () {
    $this->post(route('posts.store'), postData(['title' => '']))
        ->assertRedirect();

    $this->assertDatabaseMissing('posts', ['slug' => 'article-de-test']);
});

it('shows the edit form with the current values', function () {
    $post = Post::create(postData(['title' => 'Titre initial']));

    $this->get(route('posts.edit', $post))
        ->assertOk()
        ->assertSee('Titre initial')
        ->assertSee('Un extrait court.')
        ->assertSee('name="_method" value="PUT"', false);
});

it('updates a post and keeps its own slug', function () {
    $post = Post::create(postData());

    $this->put(route('posts.update', $post), postData(['title' => 'Titre modifié']))
        ->assertRedirect(route('posts.show', $post));

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Titre modifié',
        'slug' => 'article-de-test',
    ]);
});

it('refuses the slug of another post', function () {
    Post::create(postData(['slug' => 'slug-deja-pris']));
    $post = Post::create(postData(['slug' => 'article-a-modifier']));

    $this->from(route('posts.edit', $post))
        ->put(route('posts.update', $post), postData(['slug' => 'slug-deja-pris']))
        ->assertRedirect(route('posts.edit', $post))
        ->assertSessionHasErrors('slug');

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'slug' => 'article-a-modifier',
    ]);
});

it('deletes a post', function () {
    $post = Post::create(postData());

    $this->delete(route('posts.destroy', $post))
        ->assertRedirect(route('posts.index'));

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});

it('publishes a draft', function () {
    $post = Post::create(postData());

    $this->patch(route('posts.publication', $post))
        ->assertRedirect(route('posts.show', $post));

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'is_published' => true,
    ]);

    expect($post->fresh()->published_at)->not->toBeNull();
});

it('unpublishes a post and clears its publication date', function () {
    $post = Post::create(postData([
        'is_published' => true,
        'published_at' => now(),
    ]));

    $this->patch(route('posts.publication', $post))
        ->assertRedirect(route('posts.show', $post));

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'is_published' => false,
        'published_at' => null,
    ]);
});
