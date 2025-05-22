<div class="sidebar">
    <!-- User Panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ auth()->user()->getProfilePictureUrl() ?? asset('adminlte/dist/img/user2-160x160.jpg') }}"
                class="img-circle elevation-2" alt="User Image" style="width: 32px; height: 32px; object-fit: cover;">
        </div>
        <div class="info">
            <a href="{{ url('/profile') }}" class="d-block">{{ auth()->user()->nama }}</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

            <li class="nav-item">
                <a href="{{ url('/user/dashboard') }}"
                    class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-edit"></i>
                    <p>Fill Tracer Study</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-poll"></i>
                    <p>Fill Satisfaction Survey</p>
                </a>
            </li>

        </ul>
    </nav>
</div>