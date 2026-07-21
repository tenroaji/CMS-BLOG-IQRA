<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Article::class);

        $articles = Article::query()
            ->with(['category:id,name', 'user:id,name'])
            ->when($request->filled('search'), fn ($query) => $query->where('title', 'like', '%'.$request->string('search')->trim().'%'))
            ->when($request->filled('category'), fn ($query) => $query->where('category_id', $request->integer('category')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->user()->role !== 'admin', fn ($query) => $query->whereBelongsTo($request->user()))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('articles.index', [
            'articles' => $articles,
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', Article::class);

        return view('articles.create', ['categories' => Category::query()->orderBy('name')->get(['id', 'name'])]);
    }

    public function store(StoreArticleRequest $request): RedirectResponse
    {
        $article = Article::create($this->articleAttributes($request));

        return redirect()->route('articles.edit', $article)->with('success', 'Artikel berhasil dibuat.');
    }

    public function edit(Article $article): View
    {
        Gate::authorize('update', $article);

        return view('articles.edit', [
            'article' => $article,
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
    {
        $article->update($this->articleAttributes($request, $article));

        return redirect()->route('articles.edit', $article)->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        Gate::authorize('delete', $article);

        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function articleAttributes(StoreArticleRequest|UpdateArticleRequest $request, ?Article $article = null): array
    {
        $attributes = $request->safe()->except('thumbnail');

        if ($request->hasFile('thumbnail')) {
            if ($article?->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }

            $attributes['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $attributes['published_at'] = $attributes['status'] === 'published'
            ? ($article?->published_at ?? now())
            : null;

        if ($article === null) {
            $attributes['user_id'] = $request->user()->id;
        }

        return $attributes;
    }
}
