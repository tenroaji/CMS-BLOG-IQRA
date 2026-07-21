<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'articles' => Article::published()->with(['category:id,name', 'user:id,name'])->latest('published_at')->paginate(9),
            'categories' => Category::query()->orderBy('name')->get(['id', 'name', 'slug']),
        ]);
    }

    public function show(Article $article): View
    {
        abort_unless($article->status === 'published', 404);

        return view('blog', ['article' => $article->load(['category:id,name', 'user:id,name'])]);
    }

    public function category(Category $category, Request $request): View
    {
        return view('home', [
            'articles' => $category->articles()->published()->with(['category:id,name', 'user:id,name'])->latest('published_at')->paginate(9)->withQueryString(),
            'categories' => Category::query()->orderBy('name')->get(['id', 'name', 'slug']),
            'activeCategory' => $category,
        ]);
    }
}

/*
index() – halaman depan/list artikel published (dengan search, filter kategori, pagination)
show($slug) – halaman detail artikel + form komentar
*/
