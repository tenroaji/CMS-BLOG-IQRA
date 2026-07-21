<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-2">
                <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total artikel</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $articleCount }}</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Artikel dipublikasikan</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $publishedArticleCount }}</p>
                </div>
            </div>

            <div class="mt-6 grid gap-6 lg:grid-cols-2">
                <section class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Artikel per kategori</h3>
                    <dl class="mt-4 space-y-3">
                        @forelse ($articlesByCategory as $category)
                            <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3 dark:border-gray-700">
                                <dt class="text-gray-700 dark:text-gray-200">{{ $category->name }}</dt>
                                <dd class="font-semibold text-gray-900 dark:text-white">{{ $category->articles_count }}</dd>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">Belum ada kategori.</p>
                        @endforelse
                    </dl>
                </section>
                <section class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Artikel per penulis</h3>
                    <dl class="mt-4 space-y-3">
                        @forelse ($articlesByAuthor as $author)
                            <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3 dark:border-gray-700">
                                <dt class="text-gray-700 dark:text-gray-200">{{ $author->name }}</dt>
                                <dd class="font-semibold text-gray-900 dark:text-white">{{ $author->articles_count }}</dd>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">Belum ada penulis.</p>
                        @endforelse
                    </dl>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
