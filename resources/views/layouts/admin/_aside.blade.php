<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <img class="app-sidebar__user-avatar" style="width: 60px; height: 60px;" src="{{ asset('admin_assets/images/default.png') }}" alt="User Image">
        <div>
            <p class="app-sidebar__user-name">{{ auth()->user()->name }}</p>
            <p class="app-sidebar__user-designation">{{ auth()->user()->roles->first()->name }}</p>
        </div>
    </div>
    <ul class="app-menu">
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.home' ? 'active' : '' }}" href="{{ route('admin.home') }}">
                <i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">@lang('site.home')</span>
            </a>
        </li>

        <!-- roles -->
        @if (auth()->user()->hasPermission('read_roles'))
            <li><a class="app-menu__item {{ request()->is('*roles*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}"><i class="app-menu__icon fa fa-lock"></i> <span class="app-menu__label">@lang('roles.roles')</span></a></li>
        @endif

        <!-- admins -->
        @if (auth()->user()->hasPermission('read_admins'))
            <li><a class="app-menu__item {{ request()->is('*admins*') ? 'active' : '' }}" href="{{ route('admin.admins.index') }}"><i class="app-menu__icon fa fa-users"></i> <span class="app-menu__label">@lang('admins.admins')</span></a></li>
        @endif

        <!-- users -->
        @if (auth()->user()->hasPermission('read_users'))
            <li><a class="app-menu__item {{ request()->is('*users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="app-menu__icon fa fa-user"></i> <span class="app-menu__label">@lang('users.users')</span></a></li>
        @endif
    </ul>
</aside>