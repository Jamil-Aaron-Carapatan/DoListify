@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between items-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-cyan-800 border border-gray-300 cursor-default rounded-md">
                <i class="fas fa-chevron-left"> </i>&nbsp Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-cyan-800 border border-gray-300 rounded-md hover:bg-cyan-800/70">
                <i class="fas fa-chevron-left"> </i>&nbsp Previous
            </a>
        @endif

        {{-- Results Count --}}
        <span class="relative inline-flex items-center px-4 py-2 text-sm text-gray-700">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </span>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-cyan-800 border border-gray-300 rounded-md hover:bg-cyan-800/70">
                Next &nbsp<i class="fas fa-chevron-right"> </i> 
            </a>
        @else
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-cyan-800 border border-gray-300 cursor-default rounded-md">
                Next &nbsp<i class="fas fa-chevron-right"> </i>
            </span>
        @endif
    </nav>
@endif
