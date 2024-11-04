@include('admin.dashboard.layouts.header')

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('admin.dashboard.layouts.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                @include('admin.dashboard.layouts.topBar')
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')
                    
                    @include('admin.dashboard.layouts.footer-sans-footer')
