@include('layouts.head')

<body>
    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            @yield('content')
        </div>
    </div>
    @include('layouts/script')
</body>

</html>
