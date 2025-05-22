{{-- <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ auth()->user()->getProfilePictureUrl() ?? asset('adminlte/dist/img/user2-160x160.jpg') }}"
                class="img-circle elevation-2" style="width: 32px; height: 32px; object-fit: cover;" alt="User Image">
        </div>
        <div class="info">
            <a href="{{ url('/profile') }}" class="d-block">{{ auth()->user()->nama ?? 'Guest' }}</a>
        </div>
    </div>

    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            @role('admin')
                <li class="nav-header">ADMIN MENU</li>

                <li class="nav-item">
                    <a href="#" class="nav-link {{ $activeMenu == 'import' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-import"></i>
                        <p>Import Data</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link {{ $activeMenu == 'profession' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>Manage the Profession</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link {{ $activeMenu == 'graphic' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Graphic</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link {{ $activeMenu == 'export' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-export"></i>
                        <p>Export Data</p>
                    </a>
                </li>
            @endrole

            @role('user')
                <li class="nav-header">USER MENU</li>

                <li class="nav-item">
                    <a href="#" class="nav-link {{ $activeMenu == 'tracer' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>Fill Tracer Study</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link {{ $activeMenu == 'survey' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-poll"></i>
                        <p>Fill Satisfaction Survey</p>
                    </a>
                </li>
            @endrole

            <li class="nav-header">Logout</li>
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                    <p class="text-danger">Logout</p>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
</div> --}}
