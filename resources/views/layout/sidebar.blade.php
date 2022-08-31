<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            <img src="{{asset('assets/images/logo.png')}}" width="65px" height="50px">
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item {{ active_class(['home']) }}">
                <a href="{{ url('/home') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item nav-category">Manage Cell Down</li>
            @if(Auth::user()->usertype==1 || Auth::user()->usertype==2)
                <li class="nav-item {{ active_class(['add-cell-down']) }}">
                    <a href="{{ url('/add-cell-down') }}" class="nav-link">
                        <i class="link-icon" data-feather="save"></i>
                        <span class="link-title">Add Cell Down</span>
                    </a>
                </li>
            @endif
            <li class="nav-item {{ active_class(['view-cell-down']) }}">
                <a href="{{ url('/view-cell-down') }}" class="nav-link">
                    <i class="link-icon" data-feather="database"></i>
                    <span class="link-title">View Cell Downs</span>
                </a>
            </li>
            <li class="nav-item {{ active_class(['view-cell-up']) }}">
                <a href="{{ url('/view-cell-up') }}" class="nav-link">
                    <i class="link-icon" data-feather="database"></i>
                    <span class="link-title">View Cell Ups</span>
                </a>
            </li>
            @if(Auth::user()->usertype==1 || Auth::user()->usertype==2)
                <li class="nav-item nav-category">Report</li>
                <li class="nav-item {{ active_class(['cell-type-report']) }}">
                    <a href="{{ url('/cell-type-report') }}" class="nav-link">
                        <i class="link-icon" data-feather="pie-chart"></i>
                        <span class="link-title">Cell Type Report</span>
                    </a>
                </li>
                <li class="nav-item {{ active_class(['region-report']) }}">
                    <a href="{{ url('/region-report') }}" class="nav-link">
                        <i class="link-icon" data-feather="bar-chart"></i>
                        <span class="link-title">Region Report</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->usertype==1)
                <li class="nav-item nav-category">User Management</li>
                <li class="nav-item {{ active_class(['user-management']) }}">
                    <a href="{{ url('/user-management') }}" class="nav-link">
                        <i class="link-icon" data-feather="user-plus"></i>
                        <span class="link-title">User Details Management</span>
                    </a>
                </li>
            @endif

            <li class="nav-item nav-category">Settings</li>
            <li class="nav-item {{ active_class(['profile']) }}">
                <a href="{{ url('/profile') }}" class="nav-link">
                    <i class="link-icon" data-feather="user"></i>
                    <span class="link-title">User Profile</span>
                </a>
            </li>

        </ul>
    </div>
</nav>
