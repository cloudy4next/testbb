<ul class="list-group">
@foreach($users as $user)
  <li class="list-group-item" onClick="selectName('{{$user->name}}');">{{$user->name}}</li>
@endforeach
</ul>
