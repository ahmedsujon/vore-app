<div>
    <style>
        .pagination li{
            font-size: 12.5px;
            margin-right: 5px;
            border-radius: 4px;
        }

        .rotate_arrow{
            -webkit-transform: rotate(180deg);
            -moz-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
            -o-transform: rotate(180deg);
            transform: rotate(180deg);
        }

        .pagination_numbers{
            display: flex;
            justify-content: end;
        }
        .pagination_details{
            display: flex;
            justify-content: start;
        }
        @media screen and (max-width: 720px) {
            .pagination_numbers{
                display: flex;
                justify-content: center;
            }
            .pagination_details{
                display: flex;
                justify-content: center;
            }
        }
        .active > .page-link, .page-link.active {
            background: #343a40;
            border-color: #343a40;
        }
    </style>

    {{-- @if ($paginator->hasPages()) --}}
        <nav aria-label="Page navigation">
            <div class="row">
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="pagination_details">
                        <div class="text-md text-gray mb-2 mt-2" style="font-size: 12px;">
                            <span>{!! __('Showing') !!}</span>
                            <span class="font-medium">{{ $paginator->firstItem() }}</span>
                            <span>{!! __('to') !!}</span>
                            <span class="font-medium">{{ $paginator->lastItem() }}</span>
                            <span>{!! __('of') !!}</span>
                            <span class="font-medium">{{ $paginator->total() }}</span>
                            <span>{!! __('results') !!}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="pagination_numbers">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($paginator->onFirstPage())
                                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                                    <span class="page-link" aria-hidden="true"><div class="rotate_arrow">➤</div></span>
                                </li>
                            @else
                                <li class="page-item">
                                    <button type="button" dusk="previousPage" class="page-link" wire:click="previousPage" wire:loading.attr="disabled" rel="prev" aria-label="@lang('pagination.previous')"><div class="rotate_arrow">➤</div></button>
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
                                        @if ($paginator->currentPage() > 3 && $page == 2)
                                            <li class="page-item" aria-current="page"><span class="" style="border: none; margin-top: 5px;"><i class="fa fa-ellipsis-h ml-1 mr-1" style="margin-top: 10px;"></i></span></li>
                                        @endif
                                        @if ($page == $paginator->currentPage())
                                            <li class="page-item active" wire:key="paginator-page-{{ $page }}" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                        @elseif ($page === $paginator->currentPage() + 1 || $page === $paginator->currentPage() + 1 || $page === $paginator->currentPage() - 1 || $page === $paginator->currentPage() - 1 || $page === $paginator->lastPage() || $page === 1)
                                            <li class="page-item" wire:key="paginator-page-{{ $page }}"><button type="button" class="page-link" wire:click="gotoPage({{ $page }})">{{ $page }}</button></li>
                                        @endif
                                        @if ($paginator->currentPage() < $paginator->lastPage() - 2 && $page === $paginator->lastPage() - 1)
                                            <li class="page-item" aria-current="page"><span class="" style="border: none; margin-top: 5px;"><i class="fa fa-ellipsis-h ml-1 mr-1" style="margin-top: 10px;"></i></span></li>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($paginator->hasMorePages())
                                <li class="page-item">
                                    <button type="button" dusk="nextPage" class="page-link" wire:click="nextPage" wire:loading.attr="disabled" rel="next" aria-label="@lang('pagination.next')">➤</button>
                                </li>
                            @else
                                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                                    <span class="page-link" aria-hidden="true">➤</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    {{-- @endif --}}
</div>
