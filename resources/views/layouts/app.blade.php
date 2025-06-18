@include('layouts.head')

<body>
    <div class="main-wrapper">
        <div class="page-wrapper">

            @include('layouts.topbar')
            @include('layouts.sidebar')
            @yield('content')
            @include('layouts.footer')
        </div>
    </div>
    @include('layouts.script')

</body>
