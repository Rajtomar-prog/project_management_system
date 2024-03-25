<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset('admin-assets/dist/img/favicon.png') }}" alt="{{config('app.name')}} Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{config('app.name')}} | A CRM</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">MAIN MENU</li>
                <li class="nav-item {{ Request::segment(2) == 'home' ? 'menu-open' : '' }}">
                    <a href="{{ route('home') }}" class="nav-link {{ Request::segment(2) == 'home' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i> <p>Dashboard</p>
                    </a>
                </li>
                
                @canany(['department-list', 'department-create', 'department-edit', 'department-delete'])
                <li class="nav-item {{ Request::segment(2) == 'departments' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::segment(2) == 'departments' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Departments <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('departments.index') }}" class="nav-link {{ Route::current()->getName() == 'departments.index' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i> <p>All Departments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('departments.create')}}" class="nav-link {{ Route::current()->getName() == 'departments.create' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i> <p>Add New department</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany
               
                @can('project-list')
                <li class="nav-item {{ Request::segment(2) == 'projects' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::segment(2) == 'projects' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>Projects <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('projects.index') }}" class="nav-link {{ Route::current()->getName() == 'projects.index' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i> <p>All Projects</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('projects.create')}}" class="nav-link {{ Route::current()->getName() == 'projects.create' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i> <p>Add New project</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                @can('task-list')
                <li class="nav-item {{ Request::segment(2) == 'tasks' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::segment(2) == 'tasks' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Tasks <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('tasks.index') }}" class="nav-link {{ Route::current()->getName() == 'tasks.index' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i> <p>All Tasks</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('tasks.create')}}" class="nav-link {{ Route::current()->getName() == 'tasks.create' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i> <p>Add New Task</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                @can('status-list')
                <li class="nav-item {{ Request::segment(2) == 'status' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::segment(2) == 'status' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>Task Status <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('status.index') }}" class="nav-link {{ Route::current()->getName() == 'status.index' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i> <p>All Task Status</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('status.create')}}" class="nav-link {{ Route::current()->getName() == 'status.create' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i> <p>Add New Status</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                @can('user-list')
                <li class="nav-item {{ Request::segment(2) == 'users' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::segment(2) == 'users' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link {{ Route::current()->getName() == 'users.index' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i> <p>All Users</p>
                            </a>
                        </li>
                        @php
                            $roles = App\Models\Role::where('name', '!=', 'Admin')->get();
                        @endphp
                        @foreach ($roles as $item)
                            <li class="nav-item {{ Request::segment(4) == $item->id ? 'active' : '' }}">
                                <a href="{{ url('admin/users/user-profile-by-role', $item->id) }}"
                                    class="nav-link {{ Request::segment(4) == $item->id ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ $item->name }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                @endcan
                
                @can('role-list')
                <li class="nav-item {{ Request::segment(2) == 'roles' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::segment(2) == 'roles' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Roles <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('roles.index')}}" class="nav-link {{ Route::current()->getName() == 'roles.index' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i> <p>All Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('roles.create')}}" class="nav-link {{ Route::current()->getName() == 'roles.create' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i> <p>Add New Role</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                
                @can('permission-list')
                <li class="nav-item {{ Request::segment(2) == 'permissions' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::segment(2) == 'permissions' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-unlock"></i>
                        <p>Permissions <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('permissions.index')}}" class="nav-link {{ Route::current()->getName() == 'permissions.index' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i> <p>All Permissions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('permissions.create')}}" class="nav-link {{ Route::current()->getName() == 'permissions.create' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i> <p>Add New Permission</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                
                @can('setting-list')
                <li class="nav-item {{ Request::segment(2) == 'settings' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::segment(2) == 'settings' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Settings <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('settings.index') }}" class="nav-link {{ Route::current()->getName() == 'settings.index' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i> <p>Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> <p>Tags</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-history"></i> <p>Activity Logs</p>
                    </a>
                </li>
                <li class="nav-header">EXTRAS</li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                        <i class="nav-icon fas fa-power-off text-danger" aria-hidden="true"></i>
                        <p class="text">{{ __('Logout') }}</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>