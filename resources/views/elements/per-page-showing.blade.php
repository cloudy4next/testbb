<div class="dataTables_length" id="crudTable_length">
    <label>
        <select name="per_page_length"
                class="per-page-length custom-select custom-select-sm form-control"
                style="display: inline-block; width:34%;">
            @foreach(PER_PAGE_ITEMS as $perPageItem)
                <option
                    value="{{$perPageItem}}" {{(request()->per_page ?? 10) == $perPageItem ? 'selected' : ''}}>{{$perPageItem}}</option>
                @break($records->total() <= $perPageItem)
            @endforeach
        </select> entries per page
    </label>
</div>
