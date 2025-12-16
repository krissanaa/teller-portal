<style>
    .apb-pagination {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0;
        margin: 0;
        list-style: none;
        background: #f8fafc;
        border-radius: 12px;
    }

    .apb-pagination .page-item {
        list-style: none;
    }

    .apb-pagination .page-link {
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #475569;
        padding: 8px 12px;
        min-width: 38px;
        text-align: center;
        border-radius: 10px;
        font-weight: 600;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .apb-pagination .page-link:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        text-decoration: none;
        color: #0f172a;
    }

    .apb-pagination .page-item.disabled .page-link {
        background: #f8fafc;
        color: #cbd5e1;
        border-color: #e2e8f0;
        box-shadow: none;
        cursor: not-allowed;
    }

    .apb-pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 6px 16px rgba(20, 184, 166, 0.35);
    }
</style>

<ul class="apb-pagination">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <li class="page-item disabled" aria-disabled="true">
            <span class="page-link" aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
        </li>
    @else
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                <i class="bi bi-chevron-left"></i>
            </a>
        </li>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                <i class="bi bi-chevron-right"></i>
            </a>
        </li>
    @else
        <li class="page-item disabled" aria-disabled="true">
            <span class="page-link" aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
        </li>
    @endif
</ul>
