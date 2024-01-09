{{-- Menu Bar --}}
<header class="mb-5">
    <div class="header-top">
        <div class="container">
            <div class="logo">
                <a href="{{ route('user.dashboard') }}"><img src="{{ asset('/compiled/svg/logo.svg') }}"
                        alt="Logo"></a>
            </div>
            <div class="header-top-right">

                <div class="dropdown">
                    <a href="#" id="topbarUserDropdown"
                        class="user-dropdown d-flex align-items-center dropend dropdown-toggle "
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar avatar-md2">
                            @if (auth()->user()->foto_user)
                                <img src="{{ asset('storage/' . auth()->user()->foto_user) }}" alt="Avatar">
                            @else
                                <img src="{{ asset('compiled/jpg/1.jpg') }}" alt="Avatar">
                            @endif
                        </div>
                        <div class="text">
                            <h6 class="user-dropdown-name">{{ ucfirst(auth()->user()->name) }}</h6>
                            <p class="user-dropdown-status text-sm text-muted">
                                {{ ucfirst(implode(', ', $roles->all())) }}</p>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                        <li>
                            <h6 class="dropdown-header">Hello, {{ ucfirst(auth()->user()->name) }}!</h6>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('user.edit') }}"><i class="icon-mid bi bi-person me-2"></i> Profile saya</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf<a class="dropdown-item" href=""
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"><i
                                        class="icon-mid bi bi-box-arrow-left me-2"></i> Keluar</a>
                        </li>
                        </form>
                    </ul>
                </div>

                <!-- Burger button responsive -->
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </div>
        </div>
    </div>
    <nav class="main-navbar">
        <div class="container">
            <div class="roww">
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="{{ route('user.dashboard') }}" class='menu-link'>
                            <span><i class="bi bi-grid-fill"></i> Halaman utama</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <div class="menu-link" style="pointer-events: none;">
                            <span><i class="fas fa-calendar-day"></i> {{ $waktu_sekarang }}</span>
                        </div>
                    </li>
                </ul>
                <div class="checkbox-container">
                    <input type="checkbox" id="toggle-dark" class="checkboxx" style="cursor: pointer">
                    <label for="toggle-dark" class="checkboxx-label">
                        <i class="fas fa-moon"></i>
                        <i class="fas fa-sun"></i>
                        <span class="ball"></span>
                    </label>
                </div>
            </div>
        </div>
    </nav>
</header>
{{-- End Menu Bar --}}
