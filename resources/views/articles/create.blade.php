<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Tulis Artikel</h2></x-slot>
    <div class="py-12"><div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8"><form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data" class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">@include('articles._form')<div class="mt-6 flex gap-3"><a href="{{ route('articles.index') }}" class="rounded-md px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Batal</a><x-primary-button>Simpan Artikel</x-primary-button></div></form></div></div>
</x-app-layout>
