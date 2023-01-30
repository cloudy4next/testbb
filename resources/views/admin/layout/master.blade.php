@extends(backpack_view('blank'))

@php
	if (isset($breadcrumb)) {
		$breadcrumbs = [
			'Admin' => backpack_url('dashboard'),
		] + $breadcrumb;
	} else {
		$breadcrumbs = [
			'Admin' => backpack_url('dashboard')
		];
	}
@endphp

@section('header')
	@parent

	<div class="container-fluid">
        @include('errors.validation-errors')
        @include('elements.header-flash')
		<h2>
			<span class="text-capitalize">  @yield('page-title') </span>
			<small id="datatable_info_stack" style="display: inline-flex;" class="animated fadeIn">
				<!-- <div class="dataTables_info" id="crudTable_info" role="status" aria-live="polite">No entries.</div> -->
				<!-- <a href="http://tibhrms.com/admin/vacancylevel" class="ml-1" id="crudTable_reset_button">Reset</a> -->
			</small>
		</h2>
	</div>

@endsection

@section('after_styles')
	<link rel="stylesheet" href="{{ asset('assets/js/jquery/select2/css/select2.min.css') }}">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
	<link rel="stylesheet" href="{{ asset('assets/css/admin-custom.css') }}">
@endsection

@push('after_scripts')
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endpush
