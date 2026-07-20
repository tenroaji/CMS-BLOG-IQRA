<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



/*
index() - list artikel (admin, dengan filter status/kategori/penulis)
create(), store() - tambah artikel (termasuk upload thumbnail)
edit(), update() - edit artikel
destroy() - hapus artikel
Method tambahan: publish() atau toggle status untuk publish/unpublish
*/

class ArticleController extends Controller
{
    // Admin & Penulis bisa lihat semua artikel
    public function index()
    {
        $articles = Article::with('category', 'user')->latest()->paginate(10);
        return view('articles.index', compact('articles'));
    }

    // Admin & Penulis bisa buat artikel baru
    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = auth()->id(); // otomatis milik yang login
        Article::create($validated);

        return redirect()->route('articles.index')->with('success', 'Artikel dibuat.');
    }

    // Admin bisa edit semua, Penulis hanya edit miliknya sendiri
    public function edit(Article $article)
    {
        if (auth()->user()->role !== 'admin' && $article->user_id !== auth()->id()) {
            abort(403, 'Anda tidak punya akses ke artikel ini.');
        }

        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        if (auth()->user()->role !== 'admin' && $article->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
        ]);

        $article->update($validated);
        return redirect()->route('articles.index')->with('success', 'Artikel diperbarui.');
    }

    // Hanya Admin yang bisa hapus (sesuai contoh sebelumnya)
    public function destroy(Article $article)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa menghapus artikel.');
        }

        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Artikel dihapus.');
    }
}