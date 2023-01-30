@if ($errors->any())
    <div class="row">
        <div class="col-12">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
