@extends('admin.layout.master', [
    'breadcrumb' => [
        'Activity Log' => false,
    ],
])

@section('page-title', 'Activity Log Report')
@push('after_styles')
@endpush
@section('content')

    {{-- <div class="card">
        <div class="card-body">
            <form class="form-inline" method="get" action="{{ route('audit.log.search') }}">
                @csrf
                <nav class="nav flex-column flex-sm-row">
                    <input class="form-control mr-2" type="search" name="log_name" placeholder="Search Log Name"
                        aria-label="Search">
                    <input class="form-control mr-2" type="search" placeholder="Search Name" aria-label="Search">
                    <input class="form-control mr-2" type="date" placeholder="Search Name" aria-label="Search">
                    <input class="form-control mr-2" type="date" placeholder="Search Name" aria-label="Search">
                    <button class="btn btn-outline-success float-right" type="submit">Search</button>
                </nav>
            </form>
        </div>
    </div> --}}

    <br>
    <div class="card p-4">
        <div class="row">
            <div class="col-md-10">
                <h1>No data available</h1>
            </div>
        </div>
    </div>
@endsection
