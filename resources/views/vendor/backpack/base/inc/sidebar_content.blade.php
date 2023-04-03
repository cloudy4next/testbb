<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}</a></li>


@if (backpack_user()->hasPermissionTo('Page'))
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('page') }}'><i class='nav-icon las la-file'></i>
            Pages</a></li>
@endif

@if (backpack_user()->hasPermissionTo('News'))
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('news') }}'><i class='nav-icon las la-newspaper'></i>
            News</a></li>
@endif

@if (backpack_user()->hasPermissionTo('Article'))
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('article') }}'><i class="las la-book"></i>
            Articles</a></li>
@endif


@if (backpack_user()->hasPermissionTo('Notice'))
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('notice') }}'><i
                class='nav-icon las la-bullhorn'></i>
            Notices/Circulars</a></li>
@endif

@if (backpack_user()->hasPermissionTo('Project'))
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('project') }}'><i
                class='nav-icon las la-suitcase'></i>
            Projects</a></li>
@endif



<li class='nav-item'><a class='nav-link' href='{{ backpack_url('research') }}'><i class="lab la-researchgate"></i>
        Research</a></li>


<li class='nav-item'><a class='nav-link' href='{{ backpack_url('pptx') }}'><i class="las la-file-powerpoint"></i>
        Upload PPTX</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('query') }}'><i class='nav-icon las la-comments'></i>
        Queries</a></li>

@if (backpack_user()->hasPermissionTo('Category'))
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('category') }}'><i class='nav-icon las la-tag'></i>
            Categories</a></li>
@endif


<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon la la-files-o"></i>
        <span>Media</span></a></li>


@if (backpack_user()->hasRole('Super admin') || backpack_user()->hasPermissionTo('Settings'))
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon las la-user-cog"></i> Settings
        </a>
        <ul class="nav-dropdown-items">
            @if (backpack_user()->hasPermissionTo('Funded'))
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('funded') }}'><i
                            class='nav-icon las la-question'></i>
                        Fundeds</a></li>
            @endif
            @if (backpack_user()->hasRole('Super admin'))
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('users') }}"><i
                            class="nav-icon la la-user"></i>
                        <span>Users</span></a></li>
            @endif
            @if (backpack_user()->hasRole('Super admin'))
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i
                            class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
            @endif
            @if (backpack_user()->hasRole('Super admin'))
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i
                            class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('backup') }}'><i
                            class='nav-icon la la-hdd-o'></i> Backups</a></li>
            @endif
            @if (backpack_user()->hasRole('Super admin') || backpack_user()->hasPermissionTo('ActivityLog'))
                <li class='nav-item'><a class='nav-link' href="{{ route('audit.log.index') }}"><i
                            class='nav-icon la la-memory'></i>
                        <span>Activity Log</span></a></li>
            @endif

        </ul>
    </li>
@endif

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('newsletter') }}'><i class='nav-icon la la-question'></i> Newsletters</a></li>