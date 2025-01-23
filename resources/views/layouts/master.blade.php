<!doctype html>
<html lang="en">
@include('layouts.head')

<body>
    @include('layouts.modals')
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @include('layouts.sidebar')
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            @include('layouts.header')
            <!--  Header End -->
            <div class="container-xxl">
                @yield('content')
            </div>
        </div>
    </div>
    @include('layouts.scripts')
</body>

</html>
