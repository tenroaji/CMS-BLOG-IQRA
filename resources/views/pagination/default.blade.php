@if ($paginator->hasPages())
    <nav class="flex items-center justify-between gap-4" role="navigation" aria-label="Pagination Navigation">
        <p class="text-sm text-gray-600 dark:text-gray-300">Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} data</p>
        <div class="flex gap-2">
            @if ($paginator->onFirstPage())
                <span class="rounded-md border border-gray-200 px-3 py-2 text-sm text-gray-400 dark:border-gray-700">Sebelumnya</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="rounded-md border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">Sebelumnya</a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-500">Berikutnya</a>
            @else
                <span class="rounded-md bg-gray-200 px-3 py-2 text-sm text-gray-500 dark:bg-gray-700 dark:text-gray-400">Berikutnya</span>
            @endif
        </div>
    </nav>
@endif
