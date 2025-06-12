<div class="sidebar">
    <!-- User Panel -->
    <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

            <li class="nav-item">
                <a href="{{ route('alumni.dashboard.welcome') }}"
                    class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

             <li class="nav-item">
                <a href="{{ route('admin.dataalumni.index') }}"
                    class="nav-link {{ $activeMenu == 'data-alumni' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Profile</p>
                </a>
            </li>

            {{-- <li class="nav-header">Manage</li>
            <li class="nav-item">
                <a href="{{ route('admin.profesi.index') }}"
                    class="nav-link {{ $activeMenu == 'profesi' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-tie"></i>
                    <p>Manage the Profession</p>
                </a>
            </li> --}}

            {{--<li class="nav-header">Feedback</li>
            <li class="nav-item">
                <a href="{{ route('admin.profesi.index') }}"
                    class="nav-link {{ $activeMenu == 'profesi' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-graduate"></i>
                    <p>Tracer Study Form</p>
                </a>
            </li>--}}

            <li class="nav-header">Feedback</li>
            <li class="nav-item">
                <a href="{{ route('alumni.tracer.index') }}"
                    class="nav-link {{ $activeMenu == 'tracer' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-graduate"></i>
                <p>Tracer Study Form</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('alumni.survey.index') }}"
                    class="nav-link {{ $activeMenu == 'profesi' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-poll"></i>
                    <p>Survey Form</p>
                </a>
            </li>

            <li class="nav-header">Logout</li>
            <li class="nav-item">
                <a href="{{ url('/logout') }}" class="nav-link {{ $activeMenu == 'logout' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                    <p class="text-danger">Logout</p>
                </a>
            </li>
        </ul>
    </nav>
</div>