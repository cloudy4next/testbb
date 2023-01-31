@extends('admin.layout.master', [
    'breadcrumb' => [
        'Activity Log Report' => false,
    ],
])

@section('page-title', 'Activity Log Report')
@push('after_styles')
    <style>
        .item {
            width: 250px !important;
        }
    </style>
@endpush
@section('content')

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 offset-8">
            <button onclick="generatePDF()" class="btn btn-sm btn-success float-right mr-3"><i class="la la-download"></i>
                {{ trans('report.activity_log.download') }} </button>
            <button onclick="window.print()" class="btn btn-sm btn-success float-right mr-3"><i class="la la-print"></i>
                {{ trans('report.activity_log.print') }} </button>
        </div>
    </div>


    <div class="card mt-2">
        <div class="card-body">
            <form class="form-inline" method="get" action="{{ route('audit.log.search') }}">
                @csrf
                <nav class="nav flex-column flex-sm-row">
                    <div class="row">
                        <div class="frmSearch">
                            <input type="text" id="user_name" name="user_name" class="form-control mr-2 item"
                                placeholder="User Name" />
                            <div id="suggesstion-box"></div>
                        </div>
                        @php
                            $query['log_name'] = $query['log_name'] ?? '';
                        @endphp
                        <select class="form-control item mr-2" name="log_name">
                            <option></option>

                            @foreach ($logTypes as $logType)
                                <option value="{{ $logType->log_name }}"
                                    {{ $logType->log_name == $query['log_name'] ? 'selected' : '' }}>
                                    {{ $logType->log_name }}</option>
                            @endforeach
                        </select>

                        <input class="form-control mr-2 item" type="date" name="from"
                            value="{{ $query['from'] ?? '' }}">

                        <input class="form-control mr-2 item" type="date" name="to"
                            value="{{ $query['to'] ?? '' }}">

                        <button class="btn btn-outline-success float-right" type="submit">Search</button>
                    </div>
                </nav>
            </form>
        </div>
    </div>

    <br>
    @if ($logs->count() > 0)
        <div class="card" id="section-to-print">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">SL</th>
                        <th scope="col">Log Name</th>
                        <th scope="col">Person</th>
                        <th scope="col">Description</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($logs as $log)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ $log->log_name }}</td>
                            {{-- <td>{{ getUserName($log->causer_id) }}</td> --}}
                            <td>{{ $log->description }}</td>
                            <td>{{ date_format(date_create($log->created_at), 'j, F Y') }}</td>
                            <td>{{ date_format(date_create($log->created_at), 'h:i:s A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $logs->links() }}
    @else
        <br>
        <div class="card p-4">
            <div class="row">
                <div class="col-md-10">
                    <h1>No data match your search criteria</h1>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('after_scripts')
    <script src="{{ asset('/assets/js/html2pdf.bundle.min.js') }}"></script>
    <script type="text/javascript">
        // AJAX call for autocomplete
        $(document).ready(function() {
            $("#user_name").keyup(function(e) {
                var target = e.target;
                var name = $(this).val();


                $.ajax({
                    method: 'GET',
                    url: "{{ route('audit.log.user.name') }}",
                    data: {
                        'user_name': $(this).val()
                    },
                    beforeSend: function() {
                        // $("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
                    },
                    success: function(data) {
                        $("#suggesstion-box").show();
                        $("#suggesstion-box").html(data);
                        $("#user_name").css("background", "#FFF");
                    }
                });
            });
        });
        //To select country name
        function selectName(val) {
            $("#user_name").val(val);
            $("#suggesstion-box").hide();
        }

        function generatePDF() {
            var fileName = '{{ preg_replace('/[^a-zA-Z]+/', '-', 'Activity-log-report') }}';
            const element = document.getElementById("section-to-print");

            var options = {
                margin: 10,
                filename: fileName != '' ? fileName : 'tib-report',
                pagebreak: {
                    avoid: '.pagebreak'
                }
            };

            html2pdf().set(options)
                .from(element)
                .save();
        }
    </script>
@endpush
