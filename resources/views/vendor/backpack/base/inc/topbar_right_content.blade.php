<!-- This file is used to store topbar (right) items -->


@hasrole('Super admin')
    <li class="nav-item d-md-down-none"><a class="nav-link" href='{{ backpack_url('notification') }}'><i
                class="la la-bell"></i><span class="badge badge-pill badge-danger">{{ totalNotification(5) }}</span></a></li>
@else
    {{-- <li class="nav-item d-md-down-none"><a class="nav-link" href='{{ backpack_url('notification') }}'><i
                class="la la-bell"></i><span class="badge badge-pill badge-danger">0</span></a></li> --}}
    {{-- <li class="nav-item d-md-down-none"><a class="nav-link" href="#"><i class="la la-list"></i></a></li> --}}
    {{-- <li class="nav-item d-md-down-none"><a class="nav-link" href="#"><i class="la la-map"></i></a></li>  --}}
@endhasrole
