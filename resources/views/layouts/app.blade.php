<!DOCTYPE html>
<html lang="en">

@include('layouts.head')

<body class="loading" data-layout-color="light" data-layout="topnav" data-leftbar-theme="dark" data-layout-mode="fluid"
    data-rightbar-onstart="true">
    <!-- Begin page -->
    <div class="wrapper">

        <div class="content-page">
            <div class="content">

                @include('layouts.header')
                @include('layouts.navigation')

                @include('layouts.components')

                <div class="container-fluid">
                    @yield('content')
                </div>

            </div>

            @include('layouts.footer')

        </div>
    </div>

    @include('layouts.settings')

    <div class="rightbar-overlay"></div>

    @include('layouts.foot')

</body>

</html>
