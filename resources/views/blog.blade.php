<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('home') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">← Kembali ke artikel</a>
    </x-slot>

    <article class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
        <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400">{{ $article->category->name }}</p>
        <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">{{ $article->title }}</h1>
        <p class="mt-4 text-sm text-gray-600 dark:text-gray-300">Oleh {{ $article->user->name }} · {{ $article->published_at?->translatedFormat('d F Y') }}</p>
        @if ($article->thumbnail)
            <img src="{{ asset('storage/'.$article->thumbnail) }}" alt="Thumbnail {{ $article->title }}" class="mt-8 w-full rounded-lg object-cover">
        @endif
        <div class="mt-8 whitespace-pre-line text-base leading-8 text-gray-700 dark:text-gray-200">{{ $article->content }}</div>
    </article>
</x-app-layout>

