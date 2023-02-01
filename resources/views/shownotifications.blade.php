@extends('admin.layout.master', [
'breadcrumb' => [
{{-- 'notification' => route('notification'), --}}
'notification' => false,
]
])

@section('Notification Title', 'Notifications')
@section('content')
    @parent

    @if ($notifications->count() > 0)
        @foreach ($notifications as $notification)
            <div class="card bg-light mb-3" style="max-width: 100%; position:center;" id="noty">
                {{-- <h5 class="card-title">Special title treatment</h5> --}}
                <p class="card-text text-center"><b> {{ $notification->data['title'] }} </b>&nbsp;
                    has just registered.
                    [{{ date('j \\ F Y, g:i A', strtotime($notification->created_at)) }}]</p>
                <a href="#" class="btn btn-secondary btn-lg active mark-as-read" role="button" aria-pressed="true"
                    data-id="{{ $notification->id }}">Mark as Read</a>
            </div>
            <hr>
        @endforeach
    @else
        <p class="btn
                    btn-primary" style="display: block; margin-left: auto; margin-right: 0;">There are
            no new
            notifications</p>
    @endif

@endsection

@push('after_scripts')
    <script>
        function sendMarkRequest(id = null) {
            return $.ajax("{{ route('markNotification') }}", {
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id
                },
                success: function(data) {
                    $('#noty').remove();
                }
            });
        }
        $(function() {
            $('.mark-as-read').click(function() {
                let request = sendMarkRequest($(this).data('id'));
            });
        });
    </script>
@endpush
