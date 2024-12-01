@if ($paginator->hasPages())
<nav>
    <ul class="pagination pagination-custom justify-content-center my-3">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="page-item disabled">
            <span class="page-link">Previous</span>
        </li>
        @else
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
        </li>
        @endif

        {{-- Current Page (for mobile) --}}
        <li class="page-item active">
            <span class="page-link">{{ $paginator->currentPage() }}</span>
        </li>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
        </li>
        @else
        <li class="page-item disabled">
            <span class="page-link">Next</span>
        </li>
        @endif
    </ul>

    {{-- Full pagination for larger screens --}}
    <ul class="pagination pagination-full justify-content-center my-3">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="page-item disabled">
            <span class="page-link">Previous</span>
        </li>
        @else
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
        </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_string($element))
            <li class="page-item disabled">
                <span class="page-link">{{ $element }}</span>
            </li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
        </li>
        @else
        <li class="page-item disabled">
            <span class="page-link">Next</span>
        </li>
        @endif
    </ul>
</nav>

<style>
/* Base: Hide both by default to prevent overlap */
.pagination-custom,
.pagination-full {
    display: none;
}

/* Mobile: Show the simplified pagination */
@media (max-width: 768px) {
    .pagination-custom {
        display: flex; /* Show only mobile version */
    }
}

/* Desktop: Show the full pagination */
@media (min-width: 769px) {
    .pagination-full {
        display: flex; /* Show only desktop version */
    }
}

.pagination-custom .page-item .page-link,
.pagination-full .page-item .page-link {
    background-color: rgba(0, 0, 0, 0.7);
    color: #fff;
    border: 1px solid #444;
    margin: 0 2px;
    border-radius: 5px;
    padding: 8px 12px;
    text-align: center;
    font-size: 14px;
    transition: all 0.3s ease;
}

.pagination-custom .page-item.active .page-link,
.pagination-full .page-item.active .page-link {
    background-color: #28a745;
    color: white;
    border-color: #28a745;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}

.pagination-custom .page-item.disabled .page-link,
.pagination-full .page-item.disabled .page-link {
    background-color: transparent; 
    color: rgba(255, 255, 255, 0.6); 
    border: none; 
    cursor: default; 
    padding: 0; 
    margin: 0 4px; 
    font-weight: bold; 
    font-size: 16px;
}


@media (min-width: 769px) {
    .pagination-custom .page-item .page-link:hover,
    .pagination-full .page-item .page-link:hover {
        background-color: #444;
        color: #fff;
    }
}

@media (max-width: 768px) {
    .pagination-custom .page-link {
        padding: 6px 10px;
        font-size: 12px;
    }
}

</style>
@endif
