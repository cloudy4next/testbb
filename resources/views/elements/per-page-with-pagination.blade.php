<div class="row mt-2 d-print-none">
    @if($records->total() > PER_PAGE_ITEMS[0])
        <div class="col-sm-12 col-md-6">
            @include('elements.per-page-showing')
        </div>
    @endif
    <div class="col-sm-8 col-md-6">
        @include('elements.pagination')
    </div>
</div>
