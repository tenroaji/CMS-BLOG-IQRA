<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Kelola Artikel</h2>
            <a href="{{ route('articles.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Tulis Artikel</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-md bg-green-50 p-4 text-sm text-green-700 dark:bg-green-900/30 dark:text-green-300">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-6 rounded-md bg-red-50 p-4 text-sm text-red-700 dark:bg-red-900/30 dark:text-red-300">{{ session('error') }}</div>
            @endif

            <form method="GET" class="mb-6 grid gap-4 rounded-lg bg-white p-4 shadow-sm md:grid-cols-4 dark:bg-gray-800">
                <input name="search" value="{{ request('search') }}" placeholder="Cari judul artikel" class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                <select name="category" class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) $category->id === request('category'))>{{ $category->name }}</option>
                    @endforeach
                </select>
                <select name="status" class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    <option value="">Semua status</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                    <option value="published" @selected(request('status') === 'published')>Published</option>
                </select>
                <button class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700 dark:bg-gray-700">Filter</button>
            </form>

            <div class="overflow-x-auto rounded-lg bg-white shadow-sm dark:bg-gray-800">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Penulis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($articles as $article)
                            <tr>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $article->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $article->category->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $article->user->name }}</td>
                                <td class="px-6 py-4"><span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $article->status === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300' }}">{{ ucfirst($article->status) }}</span></td>
                                <td class="px-6 py-4 text-right text-sm">
                                    <a href="{{ route('articles.edit', $article) }}" class="font-medium text-indigo-600 hover:text-indigo-500">Edit</a>
                                    @can('delete', $article)
                                        <form method="POST" action="{{ route('articles.destroy', $article) }}" class="ml-3 inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="font-medium text-red-600 hover:text-red-500">Hapus</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">Tidak ada artikel yang ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $articles->links() }}</div>
        </div>
    </div>
</x-app-layout>
