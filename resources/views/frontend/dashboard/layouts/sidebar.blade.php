<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('user.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ __('User') }} <sup>{{ __('Panel') }}</sup></div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ setActive(['user.dashboard']) }}">
        <a class="nav-link" href="{{ route('user.dashboard') }}">
            <i class="fas fa-home"></i>
            <span>{{ __('Dashboard') }}</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item {{ setActive(['user.reservation.index']) }}">
        <a class="nav-link" href="{{ route('user.reservation.index') }}">
            <i class="fas fa-calendar-alt"></i>
            <span>{{ __('Reservation') }}</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item {{ setActive(['user.machines.index']) }}">
        <a class="nav-link" href="{{ route('user.machines.index') }}">
            <i class="fas fa-cogs"></i>
            <span>{{ __('Etat des machines') }}</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item {{ setActive(['user.calendar.index', 'user.calendar.show']) }}">
        <a class="nav-link" href="{{ route('user.calendar.index') }}">
            <i class="fas fa-calendar"></i>
            <span>{{ __('Calendrier des réservations') }}</span>
        </a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <li class="nav-item {{ setActive(['user.reclamations.index']) }}">
        <a class="nav-link" href="{{ route('user.reclamations.index') }}">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ __('Reclamation') }}</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline mt-5">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->