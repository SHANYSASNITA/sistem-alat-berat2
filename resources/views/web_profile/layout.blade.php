<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'C.V. LISAN') &mdash; Shany</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    {{-- Memanggil file CSS/Meta (Perhatikan awalan web_profile) --}}
    @include('web_profile.template.assets.profile.header')
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
    <div class="site-wrap" id="home-section">
        <div class="site-mobile-menu site-navbar-target">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close mt-3">
                    <span class="icon-close2 js-menu-toggle"></span>
                </div>
            </div>
            <div class="site-mobile-menu-body"></div>
        </div>

        {{-- Memanggil Navbar (Perhatikan awalan web_profile) --}}
        @include('web_profile.template.profile.header')

        {{-- Tempat Konten Disuntikkan --}}
        @yield('home')
        @yield('about')
        @yield('service')
        
        {{-- Anda bisa membuat yield baru khusus untuk bagian Tab Extra --}}
        @yield('extra_section') 

        @yield('tools')

        {{-- Memanggil Footer Konten (Perhatikan awalan web_profile) --}}
        @include('web_profile.template.profile.footer')
    </div>

    {{-- Memanggil file Javascript (Perhatikan awalan web_profile) --}}
    @include('web_profile.template.assets.profile.footer')
</body>
</html>