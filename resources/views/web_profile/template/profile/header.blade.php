<header class="site-navbar site-navbar-target" role="banner" style="position: fixed; top: 0; left: 0; right: 0; width: 100%; padding: 15px 0; z-index: 9999; background-color: #1a1a1a; box-shadow: 0 2px 10px rgba(0,0,0,0.3);">
    <div class="container">
        {{-- Hapus position-relative agar tidak membatasi ruang navbar --}}
        <div class="row align-items-center">
            
            {{-- Bagian Kiri (Logo) mengambil ruang 3/12 --}}
            <div class="col-3">
                <div class="site-logo">
                    <a href="index.html" class="m-0 p-0" style="font-size: 1.5rem; line-height: 1;"><strong>CV</strong>.
                        <span class="text-primary">Lisan</span>
                    </a>
                </div>
            </div>

            {{-- Bagian Kanan (Menu) mengambil sisa ruang 9/12 --}}
            <div class="col-9">
                {{-- Tombol Menu untuk HP (Didorong ke kanan) --}}
                <span class="d-inline-block d-lg-none float-right">
                    <a href="#" class="text-white site-menu-toggle js-menu-toggle py-2 text-white">
                        <span class="icon-menu h3 text-white m-0"></span>
                    </a>
                </span>

                <nav class="site-navigation text-right d-none d-lg-block" role="navigation">
                    {{-- KUNCI UTAMANYA ADA DI SINI: d-flex dan justify-content-end --}}
                    <ul class="site-menu main-menu js-clone-nav d-flex justify-content-end align-items-center m-0 p-0 w-100">
                        <li><a href="#home" class="nav-link py-2">Home</a></li>
                        <li><a href="#about" class="nav-link py-2">About</a></li>
                        <li><a href="#service" class="nav-link py-2">Services</a></li>
                        <li><a href="#tools" class="nav-link py-2">Tools</a></li>
                        
                        {{-- Saya ubah margin kirinya (ml-4) agar ada jarak sedikit dari menu Tools --}}
                        <li class="ml-4">
                            <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 py-2 d-inline-flex align-items-center" style="color: black !important; font-weight: 700; text-decoration: none;">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="mr-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                                    <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                </svg>
                                
                                Login
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>