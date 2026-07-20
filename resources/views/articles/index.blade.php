<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Daftar Artikel
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Semua Artikel</h3>

                    <a href="{{ route('articles.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md text-xs font-semibold uppercase hover:bg-indigo-500">
                        + Tulis Artikel
                    </a>
                </div>

                {{-- Tabel/list artikel di sini --}}

            </div>
        </div>
    </div>
</x-app-layout>