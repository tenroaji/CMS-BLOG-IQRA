<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'articleCount' => Article::count(),
            'publishedArticleCount' => Article::published()->count(),
            'articlesByCategory' => Category::query()->withCount('articles')->orderBy('name')->get(['id', 'name']),
            'articlesByAuthor' => User::query()->withCount('articles')->orderBy('name')->get(['id', 'name']),
        ]);
    }
}
