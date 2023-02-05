<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(\Illuminate\Support\Facades\Session::has($msg))
            <p class="alert alert-{{ $msg }}">{{ \Illuminate\Support\Facades\Session::get($msg) }}</p>
        @endif
    @endforeach
</div>
