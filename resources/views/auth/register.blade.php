@include('layouts.head')
@section('content')

    <body>
        <div class="main-wrapper login-body">
            <div class="login-wrapper">
                <div class="container">
                    <div class="loginbox">
                        <div class="login-left">
                            <img class="img-fluid" src="{{ asset('assets/img/login.png') }}" alt="Logo">
                        </div>
                        <div class="login-right">
                            <div class="login-right-wrap">
                                <h1>Sign Up</h1>
                                <p class="account-subtitle">Enter details to create your account</p>
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger">{{ $error }}</div>
                                    @endforeach
                                @endif
                                <form action="{{ route('register') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Username <span class="login-danger">*</span></label>
                                        <input class="form-control" type="text" name="username" autofocus>
                                        <span class="profile-views"><i class="fas fa-user-circle"></i></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Lengkap<span class="login-danger">*</span></label>
                                        <input class="form-control" type="text" name="namalengkap">
                                        <span class="profile-views"><i class="fas fa-user"></i></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Password <span class="login-danger">*</span></label>
                                        <input class="form-control pass-input" type="password" name="password">
                                        <span class="profile-views feather-eye-off toggle-password"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm password <span class="login-danger">*</span></label>
                                        <input class="form-control pass-confirm" type="password"
                                            name="password_confirmation">
                                        <span class="profile-views feather-eye-off reg-toggle-password"></span>
                                    </div>
                                    <div class=" dont-have">Already Registered? <a href="/">Login</a></div>
                                    <div class="form-group mb-0">
                                        <button class="btn btn-primary btn-block" type="submit">Register</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
