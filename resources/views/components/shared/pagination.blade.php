@props(['paginator'])

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-12">
        <ul class="inline-flex items-center gap-1 bg-white border border-gray-200 rounded-md shadow-sm px-3 py-2">

            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-3 py-2 text-gray-300 cursor-not-allowed">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="px-3 py-2 text-gray-600 hover:text-primary transition">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            @endif

            @for ($page = 1; $page <= $paginator->lastPage(); $page++)
                @if ($page == $paginator->currentPage())
                    <li>
                        <span class="px-3 py-2 rounded-md bg-primary text-white font-medium shadow-sm">
                            {{ $page }}
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->url($page) }}"
                           class="px-3 py-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-primary transition">
                            {{ $page }}
                        </a>
                    </li>
                @endif
            @endfor

            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="px-3 py-2 text-gray-600 hover:text-primary transition">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li>
                    <span class="px-3 py-2 text-gray-300 cursor-not-allowed">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </li>
            @endif

        </ul>
    </nav>
@endif
