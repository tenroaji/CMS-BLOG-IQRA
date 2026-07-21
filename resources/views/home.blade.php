<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ isset($activeCategory) ? 'Artikel kategori '.$activeCategory->name : 'Artikel terbaru' }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-wrap gap-2">
                <a href="{{ route('home') }}" class="rounded-full px-4 py-2 text-sm font-medium {{ ! isset($activeCategory) ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 dark:bg-gray-800 dark:text-gray-200' }}">Semua</a>
                @foreach ($categories as $category)
                    <a href="{{ route('blog.category', $category) }}" class="rounded-full px-4 py-2 text-sm font-medium {{ isset($activeCategory) && $activeCategory->is($category) ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 dark:bg-gray-800 dark:text-gray-200' }}">{{ $category->name }}</a>
                @endforeach
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($articles as $article)
                    <article class="overflow-hidden rounded-lg bg-white shadow-sm dark:bg-gray-800">
                        @if ($article->thumbnail)
                            <img src="{{ asset('storage/'.$article->thumbnail) }}" alt="Thumbnail {{ $article->title }}" class="h-48 w-full object-cover">
                        @endif
                        <div class="p-6">
                            <p class="text-sm text-indigo-600 dark:text-indigo-400">{{ $article->category->name }}</p>
                            <h2 class="mt-2 text-xl font-semibold text-gray-900 dark:text-white">{{ $article->title }}</h2>
                            <p class="mt-3 text-sm text-gray-600 dark:text-gray-300">Oleh {{ $article->user->name }} · {{ $article->published_at?->translatedFormat('d M Y') }}</p>
                            <a href="{{ route('blog.show', $article) }}" class="mt-5 inline-flex text-sm font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Baca artikel →</a>
                        </div>
                    </article>
                @empty
                    <p class="text-gray-600 dark:text-gray-300">Belum ada artikel yang dipublikasikan.</p>
                @endforelse
            </div>

            <div class="mt-8">{{ $articles->links() }}</div>
        </div>
    </div>
</x-app-layout>
