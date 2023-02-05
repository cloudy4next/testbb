@extends(backpack_view('blank'))
@push('after_styles')
    <style>
        .btn {
            position: absolute;
            right: 3%;
            bottom: 3%;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="">
        <div class="row mt-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-danger mb-3" style="max-height: 100%;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Total Articles</h5>
                        <p class="card-text text-center">{{ $totalCountArticle }}</p>
                    </div>
                </div>
            </div>

            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">
                            Total Projects
                        </h5>
                        <p class="card-text text-center">{{ $totalCountProject }}</p>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="text-white bg-dark mb-3" style="max-width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Total Share</h5>
                        <p class="card-text text-center">7</p>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Total Visitors</h5>
                        <p class="card-text text-center">189</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Online Store Visitors</h3>
                        {{-- <a href="javascript:void(0);">View Report</a> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="text-bold text-lg">820</span>
                            <span>Visitors Over Time</span>
                        </p>
                        <p class="ml-auto d-flex flex-column text-right">
                            <span class="text-success">
                                <i class="fas fa-arrow-up"></i> 12.5%
                            </span>
                            <span class="text-muted">Since last week</span>
                        </p>
                    </div>
                    <!-- /.d-flex -->

                    <div class="position-relative mb-4">
                        <canvas id="visitors-chart" height="200"></canvas>
                    </div>

                    <div class="d-flex flex-row justify-content-end">
                        <span class="mr-2">
                            <i class="fas fa-square text-primary"></i> This Week
                        </span>

                        <span>
                            <i class="fas fa-square text-gray"></i> Last Week
                        </span>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('after_scripts')
    <script src="{{ asset('assets/js/chart.js/Chart.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/jquery2/jquery.min.js') }}"></script> --}}
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js/Chart.min.js"></script> --}}
    <script src="{{ asset('assets/js/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard3.js') }}"></script>
@endpush
