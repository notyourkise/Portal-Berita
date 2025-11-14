<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- SEO Meta Tags --}}
    <title>@yield('title', 'Portal Berita - Berita Terkini Indonesia')</title>
    <meta name="description" content="@yield('meta_description', 'Portal berita terkini Indonesia dengan informasi politik, ekonomi, olahraga, teknologi, dan hiburan')">
    <meta name="keywords" content="@yield('meta_keywords', 'berita, news, indonesia, politik, ekonomi, olahraga')">
    
    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('og_title', 'Portal Berita')">
    <meta property="og:description" content="@yield('og_description', 'Berita Terkini Indonesia')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    
    {{-- RSS Feed --}}
    <link rel="alternate" type="application/rss+xml" title="Portal Berita RSS Feed" href="{{ route('rss') }}">
    
    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            overflow-x: hidden;
            max-width: 100%;
            position: relative;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: #333;
            background-color: #fff;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Dark Mode */
        body.dark-mode {
            background-color: #1a1a1a;
            color: #e0e0e0;
        }

        body.dark-mode .bg-light {
            background-color: #2a2a2a !important;
        }

        body.dark-mode .card {
            background-color: #2a2a2a;
            color: #e0e0e0;
            border-color: #3a3a3a;
        }

        body.dark-mode .card-header {
            background-color: #1f1f1f !important;
            color: #fff !important;
            border-color: #3a3a3a;
        }

        body.dark-mode .card-article {
            background-color: #2a2a2a;
            color: #e0e0e0;
        }

        body.dark-mode .list-group-item {
            background-color: #2a2a2a;
            color: #e0e0e0;
            border-color: #3a3a3a;
        }

        body.dark-mode .list-group-item:hover {
            background-color: #333;
            color: #ff9800;
        }

        body.dark-mode .text-dark {
            color: #e0e0e0 !important;
        }

        body.dark-mode .text-muted {
            color: #999 !important;
        }

        body.dark-mode .badge.bg-warning {
            background-color: #ff9800 !important;
            color: #000 !important;
        }

        /* Navbar tetap hitam di semua mode */
        .navbar-dark, .bg-dark {
            background-color: #1f1f1f !important;
        }
        
        /* Container fix */
        .container {
            max-width: 1200px;
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Navbar Styling */
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
        }

        .main-menu .nav-link {
            padding: 1rem 0.9rem;
            font-weight: 500;
            font-size: 0.9rem;
            color: #fff !important;
            transition: all 0.3s ease;
            position: relative;
        }

        .main-menu .nav-link:hover {
            background-color: #333;
            color: #ff9800 !important;
        }

        .main-menu .nav-link.active {
            background-color: #ff9800;
            color: #000 !important;
            font-weight: 600;
        }

        /* Dropdown Menu Styling */
        .mega-dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
        }

        .dropdown-menu-dark {
            background-color: #1a1a1a;
            border: none;
            border-radius: 0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            min-width: 200px;
            padding: 0.5rem 0;
        }

        .dropdown-menu-dark .dropdown-item {
            color: #ddd;
            padding: 0.6rem 1.5rem;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .dropdown-menu-dark .dropdown-item:hover {
            background-color: #333;
            color: #ff9800;
            padding-left: 2rem;
        }

        /* Search Bar */
        .form-control:focus {
            border-color: #ff9800;
            box-shadow: 0 0 0 0.2rem rgba(255, 152, 0, 0.25);
        }
        
        /* Featured Badge */
        .featured-badge {
            background: linear-gradient(135deg, #d97706 0%, #ea580c 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .card-article {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .card-article:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }
        
        .card-article img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        /* Prevent overflow */
        img {
            max-width: 100%;
            height: auto;
        }

        .row {
            margin-left: -15px;
            margin-right: -15px;
        }

        .col, .col-md-3, .col-md-4, .col-md-6, .col-lg-8, .col-lg-4 {
            padding-left: 15px;
            padding-right: 15px;
        }
        
        .category-badge {
            display: inline-block;
            align-self: flex-start;
            background: #f59e0b;
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            width: fit-content;
        }
        
        .article-meta {
            font-size: 0.875rem;
            color: #6b7280;
        }
        
        .section-title {
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: #d97706;
        }
        
        .trending-item {
            border-left: 3px solid #d97706;
            padding-left: 1rem;
            margin-bottom: 1rem;
        }
        
        .trending-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ff9800, #ff5722);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            min-width: 50px;
            text-align: center;
        }
        
        footer {
            background: #1f2937 !important;
            color: #d1d5db;
            padding: 3rem 0 1rem;
        }

        body.dark-mode footer {
            background: #0f0f0f !important;
        }
        
        footer a {
            color: #d1d5db;
            text-decoration: none;
        }
        
        footer a:hover {
            color: #d97706;
        }

        /* Responsive Media Queries */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.2rem !important;
            }

            .main-menu .nav-link {
                padding: 0.8rem 1rem;
                font-size: 0.9rem;
            }

            .container {
                padding-left: 10px;
                padding-right: 10px;
            }

            .d-flex.gap-3 {
                gap: 0.5rem !important;
            }

            .btn-primary {
                padding: 0.25rem 0.75rem;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 576px) {
            .card-article img {
                height: 150px;
            }

            .section-title {
                font-size: 1.3rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    {{-- Top Navbar (Header) --}}
    <nav class="navbar navbar-dark bg-dark py-2">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}" style="font-size: 1.5rem;">
                <span style="color: #fff;">PORTAL</span><span style="color: #ff9800;">.com</span>
            </a>
            <div class="d-flex align-items-center gap-3">
                <form action="{{ route('search') }}" method="GET" class="d-flex">
                    <input class="form-control form-control-sm" type="search" name="q" placeholder="Cari tokoh, topik atau peristiwa" value="{{ request('q') }}" style="max-width: 350px; min-width: 200px; width: 100%; border-radius: 20px;">
                    <button class="btn btn-link text-white" type="submit" style="margin-left: -40px;">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                <button id="themeToggle" class="btn btn-link text-white p-0" style="font-size: 1.3rem;">
                    <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
                </button>
            </div>
        </div>
    </nav>

    {{-- Main Menu Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-0 sticky-top" style="border-top: 1px solid #333;">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainMenu">
                <ul class="navbar-nav me-auto main-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">News</a>
                    </li>
                    
                    @php
                    $mainCategories = \App\Models\Category::where('is_active', true)->orderBy('order')->get();
                    
                    // Menu structure dengan subcategories (tags) - Dikurangi dan diubah namanya
                    $menuStructure = [
                        'Politik' => ['tags' => ['Nasional', 'Daerah', 'Pemilu', 'Pemerintahan']],
                        'Ekonomi' => ['tags' => ['Bisnis', 'Keuangan', 'Pasar Modal', 'UMKM'], 'badge' => 'HOT'],
                        'Teknologi' => ['tags' => ['Digital', 'Gadget', 'Startup', 'Inovasi']],
                        'Olahraga' => ['tags' => ['Sepakbola', 'Basket', 'Tenis', 'Bulutangkis', 'MotoGP']],
                        'Hiburan' => ['tags' => ['Film', 'Musik', 'Selebriti', 'K-Pop']],
                        'Gaya Hidup' => ['tags' => ['Fashion', 'Kuliner', 'Wisata', 'Otomotif']],
                        'Kesehatan' => ['tags' => ['Tips Sehat', 'Nutrisi', 'Olahraga', 'Mental']],
                        'Pendidikan' => ['tags' => ['Sekolah', 'Universitas', 'Beasiswa', 'Tips Belajar']],
                    ];
                    @endphp

                    @foreach($menuStructure as $menuName => $menuData)
                        @php
                        $category = $mainCategories->firstWhere('name', $menuName);
                        @endphp
                        <li class="nav-item dropdown mega-dropdown">
                            <a class="nav-link dropdown-toggle" href="{{ $category ? route('category.show', $category->slug) : '#' }}" 
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $menuName }}
                                @if(isset($menuData['badge']))
                                <span class="badge bg-danger ms-1" style="font-size: 0.6rem;">{{ $menuData['badge'] }}</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                @foreach($menuData['tags'] as $tagName)
                                <li>
                                    @php
                                    $tag = \App\Models\Tag::where('name', $tagName)->first();
                                    @endphp
                                    <a class="dropdown-item" href="{{ $tag ? route('tag.show', $tag->slug) : '#' }}">
                                        {{ $tagName }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="text-white mb-3">
                        <i class="bi bi-newspaper"></i> PortalBerita
                    </h5>
                    <p class="small">
                        Portal berita terkini Indonesia dengan informasi terpercaya seputar politik, ekonomi, olahraga, teknologi, dan hiburan.
                    </p>
                </div>
                <div class="col-md-4 mb-4">
                    <h6 class="text-white mb-3">Kategori</h6>
                    <ul class="list-unstyled small">
                        @foreach(\App\Models\Category::where('is_active', true)->orderBy('order')->get() as $cat)
                        <li class="mb-1">
                            <a href="{{ route('category.show', $cat->slug) }}">{{ $cat->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h6 class="text-white mb-3">Ikuti Kami</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="fs-4"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="fs-4"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="fs-4"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="fs-4"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center small py-3">
                <p class="mb-0">&copy; {{ date('Y') }} PortalBerita. All rights reserved.</p>
            </div>
        </div>
    </footer>

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Dark Mode Toggle Script --}}
    <script>
        // Check for saved theme preference or default to light mode
        const currentTheme = localStorage.getItem('theme') || 'light';
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');

        // Apply saved theme on page load
        if (currentTheme === 'dark') {
            document.body.classList.add('dark-mode');
            themeIcon.className = 'bi bi-sun-fill';
        }

        // Toggle theme on button click
        themeToggle.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            
            // Update icon
            if (document.body.classList.contains('dark-mode')) {
                themeIcon.className = 'bi bi-sun-fill';
                localStorage.setItem('theme', 'dark');
            } else {
                themeIcon.className = 'bi bi-moon-stars-fill';
                localStorage.setItem('theme', 'light');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
