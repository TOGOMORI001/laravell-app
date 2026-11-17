<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

beforeEach(function () {
    $this->withoutVite();
});

it('lists posts with their category, author and tags without lazy loading', function () {
    $category = Category::factory()->create(['name' => 'Tutoriels']);
    $tag = Tag::factory()->create(['name' => 'Astuce']);
    $author = User::factory()->create(['name' => 'Amira Ben Salah']);

    $posts = Post::factory(3)->published()->create([
        'category_id' => $category->id,
        'user_id' => $author->id,
    ]);

    $posts->each(fn (Post $post) => $post->tags()->attach($tag));

    $this->get(route('posts.index'))
        ->assertOk()
        ->assertSee('Tutoriels')
        ->assertSee('Amira Ben Salah')
        ->assertSee('Astuce');
});

it('keeps posts when their category is deleted', function () {
    $category = Category::factory()->create();
    $post = Post::factory()->create(['category_id' => $category->id]);

    $category->delete();

    $this->assertDatabaseHas('posts', ['id' => $post->id]);
    expect($post->fresh()->category_id)->toBeNull();
});

it('replaces a post tags with sync', function () {
    $post = Post::factory()->create();
    $tags = Tag::factory(3)->create();

    $post->tags()->attach([$tags[0]->id, $tags[1]->id]);
    $post->tags()->sync([$tags[1]->id, $tags[2]->id]);

    expect($post->tags()->count())->toBe(2);
    $this->assertDatabaseMissing('post_tag', ['post_id' => $post->id, 'tag_id' => $tags[0]->id]);
    $this->assertDatabaseHas('post_tag', ['post_id' => $post->id, 'tag_id' => $tags[2]->id]);
});

it('removes pivot rows when a post is deleted', function () {
    $post = Post::factory()->create();
    $tag = Tag::factory()->create();
    $post->tags()->attach($tag);

    $this->delete(route('posts.destroy', $post));

    $this->assertDatabaseMissing('post_tag', ['post_id' => $post->id]);
    $this->assertDatabaseHas('tags', ['id' => $tag->id]);
});

it('shows up to three other published posts in the same category', function () {
    $category = Category::factory()->create();
    $post = Post::factory()->published()->create([
        'category_id' => $category->id,
        'title' => 'Article courant',
        'published_at' => now()->subDays(10),
    ]);

    foreach (range(1, 4) as $number) {
        Post::factory()->published()->create([
            'category_id' => $category->id,
            'title' => "Voisin publié {$number}",
            'published_at' => now()->subDays(4 - $number),
        ]);
    }

    Post::factory()->create([
        'category_id' => $category->id,
        'title' => 'Voisin brouillon',
    ]);
    Post::factory()->published()->create(['title' => 'Autre catégorie']);

    $response = $this->get(route('posts.show', $post));
    $content = $response->getContent();

    $response
        ->assertOk()
        ->assertSee('Dans la même catégorie')
        ->assertSee('Voisin publié 4')
        ->assertSee('Voisin publié 3')
        ->assertSee('Voisin publié 2')
        ->assertDontSee('Voisin publié 1')
        ->assertDontSee('Voisin brouillon')
        ->assertDontSee('Autre catégorie');

    expect(substr_count($content, '<article'))->toBe(4);
});

it('does not show same-category posts when the current post has no category', function () {
    $post = Post::factory()->published()->create();

    $this->get(route('posts.show', $post))
        ->assertOk()
        ->assertDontSee('Dans la même catégorie');
});

it('does not show the same-category section when there are no other published posts', function () {
    $category = Category::factory()->create();
    $post = Post::factory()->published()->create(['category_id' => $category->id]);
    Post::factory()->create(['category_id' => $category->id]);

    $this->get(route('posts.show', $post))
        ->assertOk()
        ->assertDontSee('Dans la même catégorie');
});
