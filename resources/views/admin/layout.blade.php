<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin - SIMAT C.V. LISAN</title>

    <script src="{{ asset('assets/js/color-modes.js') }}"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo1/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
    
    @stack('styles')
</head>

<body>
    <div class="main-wrapper">

        <nav class="sidebar">
            <div class="sidebar-header">
                <a href="#" class="sidebar-brand">
                    CV.<span>LISAN</span>
                </a>
                <div class="sidebar-toggler not-active">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div class="sidebar-body">
                <ul class="nav" id="sidebarNav">
                    
                    <li class="nav-item nav-category">Main</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="link-icon" data-lucide="box"></i>
                            <span class="link-title">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item nav-category">Data Master</li>
                    <li class="nav-item">
                        <a href="{{ route('alat.index') }}" class="nav-link {{ request()->routeIs('alat.*') ? 'active' : '' }}">
                            <i class="link-icon" data-lucide="tractor"></i>
                            <span class="link-title">Alat Berat</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('operator.index') }}" class="nav-link {{ request()->routeIs('operator.*') ? 'active' : '' }}">
                            <i class="link-icon" data-lucide="hard-hat"></i>
                            <span class="link-title">Operator</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pelanggan.index') }}" class="nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                            <i class="link-icon" data-lucide="users"></i>
                            <span class="link-title">Pelanggan</span>
                        </a>
                    </li>

                    <li class="nav-item nav-category">Web Profile</li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#webProfileCollapse" role="button" 
                            aria-expanded="{{ request()->is('admin/web-profile*') ? 'true' : 'false' }}" aria-controls="webProfileCollapse">
                                <i class="link-icon" data-lucide="globe"></i>
                                <span class="link-title">Manajemen Landing</span>
                                <i class="link-arrow" data-lucide="chevron-down"></i>
                            </a>
                            <div class="collapse {{ request()->is('admin/web-profile*') ? 'show' : '' }}" id="webProfileCollapse" data-bs-parent="#sidebarNav">
                                <ul class="nav sub-menu">
                                    {{-- 1. Hero Section --}}
                                    <li class="nav-item">
                                        <a href="{{ route('admin.hero') }}" class="nav-link {{ request()->routeIs('admin.hero') ? 'active' : '' }}">
                                            <i data-lucide="image" style="width: 14px; height: 14px; margin-right: 8px;"></i> Hero Section
                                        </a>
                                    </li>  

                                    {{-- 2. About Us --}}
                                    <li class="nav-item">
                                        <a href="{{ route('admin.about') }}" class="nav-link {{ request()->routeIs('admin.about') ? 'active' : '' }}">
                                            <i data-lucide="info" style="width: 14px; height: 14px; margin-right: 8px;"></i> About Us
                                        </a>                
                                    </li>

                                    {{-- 3. Services --}}
                                    <li class="nav-item">
                                        <a href="{{ route('admin.services') }}" class="nav-link {{ request()->routeIs('admin.services') ? 'active' : '' }}">
                                            <i data-lucide="briefcase" style="width: 14px; height: 14px; margin-right: 8px;"></i> Services
                                        </a>
                                    </li>  

                                    {{-- 4. Katalog Tools --}}
                                    <li class="nav-item">
                                        <a href="{{ route('pricing.index') }}" class="nav-link {{ request()->routeIs('alat.*') ? 'active' : '' }}">
                                            <i data-lucide="truck" style="width: 14px; height: 14px; margin-right: 8px;"></i> Katalog Tools
                                        </a>
                                    </li> 
                                </ul>
                            </div>
                        </li>

                    <li class="nav-item nav-category">Operasional</li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#transaksi" role="button" 
                           aria-expanded="{{ request()->routeIs('transaksi.*') || request()->routeIs('dp.*') ? 'true' : 'false' }}" aria-controls="transaksi">
                            <i class="link-icon" data-lucide="file-text"></i>
                            <span class="link-title">Transaksi</span>
                            <i class="link-arrow" data-lucide="chevron-down"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('transaksi.*') || request()->routeIs('dp.*') ? 'show' : '' }}" id="transaksi" data-bs-parent="#sidebarNav">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{ route('transaksi.index') }}" class="nav-link {{ request()->routeIs('transaksi.index') ? 'active' : '' }}">Penyewaan</a>
                                </li>  
                                <li class="nav-item">
                                    <a href="{{ route('dp.index') }}" class="nav-link {{ request()->routeIs('dp.index') ? 'active' : '' }}">Pembayaran</a>                
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('timesheet.index') }}" class="nav-link {{ request()->routeIs('timesheet.*') ? 'active' : '' }}">
                            <i class="link-icon" data-lucide="calendar"></i>
                            <span class="link-title">Timesheet</span>
                        </a>                
                    </li>

                    <li class="nav-item nav-category">Settings</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="link-icon" data-lucide="users"></i>
                            <span class="link-title">Akun</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="link-icon" data-lucide="user-cog"></i>
                            <span class="link-title">Profile</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        
        <div class="page-wrapper">
            <nav class="navbar">
                <div class="navbar-content">
                    <ul class="navbar-nav">
                        <li class="theme-switcher-wrapper nav-item">
                            <input type="checkbox" value="" id="theme-switcher">
                            <label for="theme-switcher">
                                <div class="box">
                                    <div class="ball"></div>
                                    <div class="icons">
                                        <i data-lucide="sun"></i>
                                        <i data-lucide="moon"></i>
                                    </div>
                                </div>
                            </label>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="w-30px h-30px ms-1 rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold">A</div>
                            </a>
                            <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                                <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                                    <div class="text-center">
                                        <p class="fs-16px fw-bolder">Admin Lisan</p>
                                        <p class="fs-12px text-secondary">admin@cvlisan.com</p>
                                    </div>
                                </div>
                                <ul class="list-unstyled p-1">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                            @csrf
                                            <button type="submit" class="dropdown-item py-2 text-danger border-0 bg-transparent w-100 text-start">
                                                <i class="me-2 icon-md" data-lucide="log-out"></i> <span>Log Out</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>

                    <a href="#" class="sidebar-toggler">
                        <i data-lucide="menu"></i>
                    </a>
                </div>
            </nav>
            
            <div class="page-content container-xxl">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <i data-lucide="check-circle" class="me-2 icon-md"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
            
            <footer class="footer d-flex flex-row align-items-center justify-content-center px-5 py-4 border-top small">
                <p class="text-secondary text-center mb-0">Copyright © 2026 <br>
                    <a href="#" class="text-primary decoration-none">Sistem Manajemen Alat Berat</a>
                    <i class="mb-1 text-primary ms-1 icon-sm" data-lucide="heart"></i>
                </p>
            </footer>
        </div>
    </div>

    <script src="{{ asset('assets/vendors/core/core.js') }}"></script>
    <script src="{{ asset('assets/vendors/lucide/lucide.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script> 
    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>