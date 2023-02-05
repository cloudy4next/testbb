@extends('admin.layout.master', [
'breadcrumb' => [
{{-- 'page' => route('admin.page'), --}}
'page add' => false,
]
])

@section('page-title', 'edit page')

@section('content')
    @parent
    <div class="row" id="content">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                {!! Form::open([
                    'route' => ['admin.page.update', $data->id],
                    'autocomplete' => 'off',
                    'class' => 'form-horizontal',
                    'novalidate',
                    'files' => true,
                ]) !!}
                <div class="card-header">
                    <i class="la la-plus"></i> Create page
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
                            <label for="tile"> Title </label> <span class="text-danger">*</span>
                            {!! Form::text('title', $data->title, [
                                'class' => 'form-control title',
                                'id' => 'job-title',
                                'tabindex' => 1,
                                'required' => 'required',
                                'data-error' => 'Title field is require',
                                'placeholder' => 'Enter title',
                            ]) !!}
                            <div class="help-block with-errors text-danger"></div>
                            @if ($errors->has('title'))
                                <span class="text-danger"><strong>{{ $errors->first('title') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                            <label for="category"> Category </label> <span class="text-danger">*</span>
                            {!! Form::select('category_id', $category, $data->category_id, '--', [
                                'class' => 'form-control category',
                                'id' => 'category_id',
                                'tabindex' => 2,
                                'required' => 'required',
                                'data-error' => 'This field is required',
                            ]) !!}
                            <div class="help-block with-errors text-danger"></div>
                            @if ($errors->has('category'))
                                <span class="text-danger"><strong>{{ $errors->first('category') }}</strong></span>
                            @endif
                        </div>

                        <div class="form-group col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                            <label for="status"> Status </label> <span class="text-danger">*</span>
                            {!! Form::select('status', ['published' => 'Published', 'unpublished' => 'Unpublished'], $data->status, [
                                'class' => 'form-control status',
                                'id' => 'status',
                                'tabindex' => 4,
                                'required' => 'required',
                                'data-error' => 'This field is required',
                            ]) !!}
                            <div class="help-block with-errors text-danger"></div>
                            @if ($errors->has('status'))
                                <span class="text-danger"><strong>{{ $errors->first('status') }}</strong></span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-3 col-lg-3 col-xl-12">
                                <label for="upload" class="form-label">Upload(max 2 MB)</label> <span
                                    class="text-danger">*</span>
                                {!! Form::file('image', [
                                    'class' => 'form-control image',
                                    'id' => 'image',
                                    'rows' => '2',
                                    'placeholder' => 'Upload Image',
                                    'tabindex' => 5,
                                    'required' => 'required',
                                ]) !!}
                                @if ($errors->has('upload'))
                                    <span class="text-danger"><strong>{{ $errors->first('upload') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        </div>
                        <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <label class="form-label">Uploaded files : </label>
                            @php
                                $fileDatum = $data->image;
                                if ($fileDatum == null) {
                                    echo '<div><small>File not found.</small></div>';
                                }
                            @endphp
                            {{-- {{ $data->image }} --}}
                            <div> <a href="{{ URL::to('/uploads/page/' . $data->image) }}" download>
                                    {{ $data->image }} </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <label for="description"> Description </label><span class="text-danger">*</span>
                            {!! Form::textarea('description', $data->description, [
                                'class' => 'form-control description',
                                'id' => 'description',
                                'rows' => '2',
                                'placeholder' => 'Enter page description',
                                'tabindex' => 5,
                                'required' => 'required',
                                'data-error' => trans('exam.validator_massege'),
                            ]) !!}
                            <div class="help-block with-errors text-danger"></div>
                            @if ($errors->has('description'))
                                <span class="text-danger"><strong>{{ $errors->first('description') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success question-set-submit">
                        <span class="la la-save"></span> &nbsp;
                        <span class="mr-3"> Save </span>
                    </button>

                    <a href="{!! url('/admin/page') !!}" class="btn btn-default"><span class="la la-ban"></span>
                        &nbsp;Cancel</a>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@push('after_styles')
    <link rel="stylesheet" href="{{ asset('/packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}" />
@endpush

@push('after_scripts')
    <script src="{{ asset('/packages/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
    <script src="{{ asset('assets/js/jquery/select2/js/select2.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.15.1/standard-all/ckeditor.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            CKEDITOR.replace('description', {
                height: 200
            });

            $('.category').select2({
                theme: "bootstrap",
                placeholder: "Select category"
            });

            $('.status').select2({
                theme: "bootstrap",
                placeholder: "Select status"
            });
        });
    </script>
@endpush
