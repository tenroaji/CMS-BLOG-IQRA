<?php

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('guests only see published articles on the public homepage', function () {
    $publishedArticle = Article::factory()->published()->create(['title' => 'Artikel Publik']);
    Article::factory()->create(['title' => 'Artikel Draft']);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee($publishedArticle->title)
        ->assertDontSee('Artikel Draft');
});

test('penulis can only see their own articles in the management list', function () {
    $penulis = User::factory()->create(['role' => 'penulis']);
    $otherPenulis = User::factory()->create(['role' => 'penulis']);
    $ownArticle = Article::factory()->for($penulis)->create(['title' => 'Artikel Saya']);
    Article::factory()->for($otherPenulis)->create(['title' => 'Artikel Penulis Lain']);

    $this->actingAs($penulis)
        ->get(route('articles.index'))
        ->assertSuccessful()
        ->assertSee($ownArticle->title)
        ->assertDontSee('Artikel Penulis Lain');
});

test('penulis cannot edit another penulis article', function () {
    $penulis = User::factory()->create(['role' => 'penulis']);
    $article = Article::factory()->create();

    $this->actingAs($penulis)
        ->get(route('articles.edit', $article))
        ->assertForbidden();
});

test('admin can create a category', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->post(route('categories.store'), ['name' => 'Teknologi'])
        ->assertRedirect(route('categories.index'));

    expect(Category::where('slug', 'teknologi')->exists())->toBeTrue();
});

test('penulis can upload a published article thumbnail', function () {
    Storage::fake('public');

    $penulis = User::factory()->create(['role' => 'penulis']);
    $category = Category::factory()->create();
    $thumbnail = UploadedFile::fake()->image('thumbnail.jpg');

    $this->actingAs($penulis)
        ->post(route('articles.store'), [
            'title' => 'Artikel Baru',
            'category_id' => $category->id,
            'content' => 'Isi artikel yang cukup panjang.',
            'status' => 'published',
            'thumbnail' => $thumbnail,
        ])
        ->assertRedirect();

    $article = Article::where('title', 'Artikel Baru')->firstOrFail();

    expect($article->status)->toBe('published')
        ->and($article->published_at)->not->toBeNull()
        ->and($article->thumbnail)->not->toBeNull();

    Storage::disk('public')->assertExists($article->thumbnail);
});
