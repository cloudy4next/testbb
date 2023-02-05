@extends('admin.layout.master', [
'breadcrumb' => [
{{-- 'query' => route('admin.query'), --}}
'query' => false,
]
])

@section('query-title', 'Queries')

@section('content')
    @parent
    <div class="row" id="content">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                {!! Form::open([
                    'route' => ['admin.query.read', $queries->id],
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
                        <div class="form-group col-12 col-sm-12 col-md-9 col-lg-9 col-xl-12">
                            <label for="tile"> Title </label>
                            {!! Form::text('title', $queries->title, [
                                'class' => 'form-control text-muted',
                                'id' => 'job-title',
                                'tabindex' => 1,
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-12 col-sm-12 col-md-3 col-lg-3 col-xl-12">
                            <label for="email"> Email </label>
                            {!! Form::text('email_id', $queries->email, [
                                'class' => 'form-control email text-muted',
                                'id' => 'email_id',
                                'tabindex' => 4,
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="form-group col-12 col-sm-12 col-md-3 col-lg-3 col-xl-12">
                            <label for="mobile"> Mobile </label>
                            {!! Form::text('mobile', $queries->mobile, [
                                'class' => 'form-control mobile',
                                'id' => 'mobile',
                                'tabindex' => 4,
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <label for="description"> Description </label>
                            {!! Form::textarea('description', $queries->description, [
                                'class' => 'form-control text-muted',
                                'id' => 'description',
                                'rows' => '2',
                                'disabled' => 'disabled',
                            ]) !!}

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success question-set-submit">
                        <span class="la la-save"></span> &nbsp;
                        <span class="mr-3"> Mark as Read </span>
                    </button>

                    <a href="{!! url('/admin/query') !!}" class="btn btn-default"><span class="la la-ban"></span>
                        &nbsp;Cancel</a>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
