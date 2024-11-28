<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ __('Admin') }} <sup>{{ __('Panneau') }}</sup></div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ setActive(['admin.dashboard']) }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-home"></i>
            <span>{{ __('Tableau de bord') }}</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ setActive(['admin.analytics.index']) }}">
        <a class="nav-link" href="{{ route('admin.analytics.index') }}">
            <i class="fas fa-home"></i>
            <span>{{ __('Analytics') }}</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item {{ setActive(['admin.reservation.index','admin.reservation.edit','admin.showReservationForm']) }}">
        <a class="nav-link" href="{{ route('admin.reservation.index') }}">
            <i class="fas fa-calendar"></i>
            <span>{{ __('Réservations') }}</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item {{ setActive(['admin.calendar.reservation']) }}">
        <a class="nav-link" href="{{ route('admin.calendar.reservation') }}">
            <i class="fas fa-calendar"></i>
            <span>{{ __('Calendrier des réservations') }}</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item {{ setActive(['admin.machines.index', 'admin.machines.create']) }}">
        <a class="nav-link" href="{{ route('admin.machines.index') }}">
            <i class="fas fa-fw fa-cogs"></i>
            <span>{{ __('Machines') }}</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item {{ setActive(['admin.users.index', 'admin.users.create']) }}">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>{{ __('Gestion des utilisateurs') }}</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item {{ setActive(['admin.reclamations.index']) }}">
        <a class="nav-link" href="{{ route('admin.reclamations.index') }}">
            <i class="fas fa-fw fa-exclamation-circle"></i>
            <span>{{ __('Réclamations') }}</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ setActive(['admin.settings.reservations', 'admin.settings.DomainRestriction']) }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-cogs"></i>
            <span>{{ __('Paramètres') }}</span>
        </a>
        <div id="collapsePages" class="collapse {{ isMenuOpen(['admin.settings.reservations', 'admin.settings.DomainRestriction']) }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('admin.settings.reservations') }}">
                    <i class="fas fa-fw fa-calendar-alt"></i>
                    {{ __('Réservations') }}
                </a>
                <a class="collapse-item" href="{{ route('admin.settings.DomainRestriction') }}">
                    <i class="fas fa-fw fa-shield-alt"></i>
                    {{ __('Autorisation') }}
                </a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->