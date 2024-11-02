@include('frontend.dashboard.layouts.header')

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('frontend.dashboard.layouts.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                @include('frontend.dashboard.layouts.topBar')
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')
                    
                    @include('frontend.dashboard.layouts.footer-sans-footer')
