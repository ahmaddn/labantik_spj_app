@include('layouts.head')

<body>
    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            @yield('content')
            @include('layouts/script')
        </div>
    </div>
</body>

</html>
