<div class="header">
    <div class="header-left">
        <a href="#" class="logo">
            <img src="{{ asset('assets/img/logosmk.png') }}" alt="Logo">
        </a>
        <a href="#" class="logo logo-small">
            <img src="{{ asset('assets/img/logosmk.png') }}" alt="Logo" width="50" height="50">
        </a>
    </div>
    <div class="menu-toggle">
        <a href="javascript:void(0);" id="toggle_btn">
            <i class="fas fa-bars"></i>
        </a>
    </div>

    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>

    <ul class="nav user-menu">

        <li class="nav-item zoom-screen me-2">
            <a href="#" class="nav-link header-nav-list win-maximize">
                <img src="{{ asset('assets/img/icons/header-icon-04.svg') }}" alt="">
            </a>
        </li>
        @php
            $nama = Auth::user()->namalengkap ?? '';
            $inisial = collect(explode(' ', $nama))
                ->take(2)
                ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                ->implode('');
        @endphp
        <li class="nav-item dropdown has-arrow new-user-menus">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <div
                        class="avatar avatar-sm rounded-circle bg-primary-light d-flex align-items-center justify-content-center">
                        <span>{{ $inisial }}</span>
                    </div>
                    <div class="user-text">
                        <h6></h6>
                        <p class="text-muted mb-0"></p>
                    </div>
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="user-header">
                    <div class="user-text">
                        <h6>{{ Auth::user()->namalengkap }}</h6>
                        <p class="text-muted mb-0">Administrator</p>
                    </div>
                </div>
                <a class="dropdown-item" href="{{ route('profile') }}">My Profile</a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="dropdown-item" type="submit">Logout</button>
                </form>
            </div>
        </li>
    </ul>
</div>
