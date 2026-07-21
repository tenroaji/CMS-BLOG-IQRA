@csrf
<div class="grid gap-6">
    <div>
        <x-input-label for="title" value="Judul" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $article->title ?? '')" required autofocus />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="category_id" value="Kategori" />
        <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" required>
            <option value="">Pilih kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) $category->id === (string) old('category_id', $article->category_id ?? ''))>{{ $category->name }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="content" value="Isi artikel" />
        <textarea id="content" name="content" rows="12" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" required>{{ old('content', $article->content ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('content')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="thumbnail" value="Thumbnail (opsional, maksimal 2 MB)" />
        <input id="thumbnail" name="thumbnail" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-600 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100 dark:text-gray-300 dark:file:bg-indigo-900/50 dark:file:text-indigo-200">
        @isset($article)
            @if ($article->thumbnail)
                <img src="{{ asset('storage/'.$article->thumbnail) }}" alt="Thumbnail saat ini" class="mt-3 h-24 rounded object-cover">
            @endif
        @endisset
        <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="status" value="Status" />
        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" required>
            <option value="draft" @selected(old('status', $article->status ?? 'draft') === 'draft')>Draft</option>
            <option value="published" @selected(old('status', $article->status ?? 'draft') === 'published')>Publish</option>
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>
</div>
