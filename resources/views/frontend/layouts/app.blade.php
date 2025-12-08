<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- SEO Meta Tags --}}
    <title>@yield('title', 'SALUT UT Samarinda - Sentra Layanan Universitas Terbuka')</title>
    <meta name="description" content="@yield('meta_description', 'SALUT UT Samarinda adalah Sentra Layanan Universitas Terbuka di Samarinda yang memberikan layanan akademik, pendampingan belajar, dan informasi pendidikan untuk mahasiswa UT')">
    <meta name="keywords" content="@yield('meta_keywords', 'SALUT, Universitas Terbuka, UT Samarinda, kuliah online, pendaftaran mahasiswa, tutorial online, layanan akademik')">
    
    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('og_title', 'SALUT UT Samarinda')">
    <meta property="og:description" content="@yield('og_description', 'Sentra Layanan Universitas Terbuka Samarinda')">
    <meta property="og:image" content="@yield('og_image', asset('LOGO_SALUT_.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    
    {{-- Favicon - Using SVG logo UT --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo-ut.svg') }}?v={{ time() }}">
    <link rel="alternate icon" type="image/png" href="{{ asset('LOGO_SALUT_.png') }}?v={{ time() }}">
    <link rel="apple-touch-icon" href="{{ asset('LOGO_SALUT_.png') }}?v={{ time() }}">
    
    {{-- RSS Feed --}}
    <link rel="alternate" type="application/rss+xml" title="SALUT UT Samarinda RSS Feed" href="{{ route('rss') }}">
    
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
            scroll-behavior: smooth;
        }

        /* Lock body scroll saat menu mobile terbuka */
        body.menu-open {
            overflow: hidden;
            position: fixed;
            width: 100%;
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
            color: #fcdd01;
        }

        body.dark-mode .text-dark {
            color: #e0e0e0 !important;
        }

        body.dark-mode .text-muted {
            color: #999 !important;
        }

        body.dark-mode .badge.bg-warning {
            background-color: #fcdd01 !important;
            color: #000 !important;
        }

        /* Top navbar with white background */
        .navbar-light.bg-white {
            background-color: #ffffff !important;
        }

        /* Menu navbar with blue background */
        .navbar-dark {
            background-color: #214594 !important;
        }
        
        /* Container fix */
        .container {
            max-width: 1200px;
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Navbar Fixed */
        .navbar-fixed-top {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 1031;
        }

        .navbar-fixed-menu {
            position: fixed;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 1030;
        }

        /* Offset untuk konten agar tidak tertutup navbar */
        body {
            padding-top: 165px; /* Total tinggi kedua navbar yang proporsional */
        }

        /* Navbar Light (Logo Navbar) */
        .navbar-light.bg-white.navbar-fixed-top {
            top: 0;
            transition: top 0.3s ease-in-out;
        }

        /* Navbar Dark (Menu Navbar) */
        .navbar-dark.navbar-fixed-menu {
            top: 95px; /* Tinggi navbar atas + border */
            transition: top 0.3s ease-in-out;
        }

        /* Navbar Styling */
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
        }

        .navbar-brand img {
            height: 60px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        /* Hamburger Menu - Positioned Right */
        .navbar-toggler {
            border: 2px solid #fcdd01;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .navbar-toggler:hover {
            background-color: #fcdd01;
            border-color: #fcdd01;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.25rem rgba(252, 221, 1, 0.25);
        }

        .navbar-toggler-icon {
            width: 1.5rem;
            height: 1.5rem;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28252, 221, 1, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2.5' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .navbar-toggler:hover .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280, 0, 0, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2.5' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .main-menu .nav-link {
            padding: 1.3rem 1.6rem;
            font-weight: 600;
            font-size: 1.15rem;
            color: #fff !important;
            transition: all 0.3s ease;
            position: relative;
            text-decoration: none;
        }

        .main-menu .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: 10px;
            left: 50%;
            background-color: #fcdd01;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .main-menu .nav-link:hover {
            color: #fcdd01 !important;
        }

        .main-menu .nav-link:hover::after {
            width: 80%;
        }

        .main-menu .nav-link.active {
            color: #fcdd01 !important;
            font-weight: 600;
        }

        .main-menu .nav-link.active::after {
            width: 80%;
        }

        /* Dropdown Menu Styling */
        .mega-dropdown {
            position: relative;
        }

        .mega-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: auto;
            min-width: 800px;
            background-color: #ffffff;
            border: none;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
            padding: 2rem;
            display: none;
            z-index: 10000;
            margin-top: 0;
        }

        .mega-dropdown:hover .mega-dropdown-menu {
            display: block;
        }

        .mega-dropdown-menu .mega-section {
            padding: 1rem;
        }

        .mega-dropdown-menu .mega-image {
            border-radius: 8px;
            overflow: hidden;
            height: 100%;
        }

        .mega-dropdown-menu .mega-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mega-dropdown-menu h5 {
            color: #214594;
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .mega-dropdown-menu .mega-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 0;
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
            border-bottom: 1px solid #f0f0f0;
        }

        .mega-dropdown-menu .mega-link:last-child {
            border-bottom: none;
        }

        .mega-dropdown-menu .mega-link:hover {
            color: #214594;
            padding-left: 10px;
        }

        .mega-dropdown-menu .mega-link i {
            font-size: 1.5rem;
            color: #214594;
            margin-right: 1rem;
            width: 30px;
            text-align: center;
        }

        .mega-dropdown-menu .mega-link:hover i {
            color: #fcdd01;
        }

        /* Desktop: hover to show */
        @media (min-width: 992px) {
            .mega-dropdown:hover .dropdown-menu {
                display: block;
                margin-top: 0;
            }
        }

        /* Mobile: click to toggle */
        @media (max-width: 991.98px) {
            .dropdown-menu {
                display: none;
                position: static;
                float: none;
                width: 100%;
                margin: 0;
                border: none;
                box-shadow: none;
            }

            .dropdown-menu.show {
                display: block;
            }

            .nav-item.show > .dropdown-menu {
                display: block;
            }

            /* Mobile mega dropdown styling */
            .mega-dropdown-menu {
                display: none; /* Default hidden, toggle via JS */
                position: static !important;
                min-width: 100% !important;
                width: 100% !important;
                padding: 1rem;
                background-color: #1a3670 !important;
                border-radius: 0 !important;
                max-height: 50vh;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            .mega-dropdown.show .mega-dropdown-menu {
                display: block;
            }

            .mega-dropdown-menu .row {
                flex-direction: column;
            }

            .mega-dropdown-menu .mega-section {
                padding: 0.5rem;
            }

            .mega-dropdown-menu .mega-image {
                display: none; /* Hide image on mobile */
            }

            .mega-dropdown-menu h5 {
                color: #fcdd01 !important;
                font-size: 1rem;
                margin-bottom: 1rem;
            }

            .mega-dropdown-menu p.text-muted {
                color: #ccc !important;
            }

            .mega-dropdown-menu .mega-link {
                color: #fff !important;
                border-bottom-color: #333 !important;
                padding: 0.6rem 0;
            }

            .mega-dropdown-menu .mega-link:hover {
                color: #fcdd01 !important;
            }

            .mega-dropdown-menu .mega-link i {
                color: #fcdd01 !important;
            }

            .mega-dropdown-menu .d-flex.gap-3 {
                flex-direction: column !important;
                gap: 0.5rem !important;
            }

            .mega-dropdown-menu .d-flex.gap-3 .mega-link {
                border: 1px solid #444 !important;
                border-radius: 8px;
                padding: 0.8rem !important;
            }

            /* Navbar collapse scrollable */
            .navbar-collapse {
                max-height: calc(100vh - 120px);
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }
        }

        .dropdown-menu-dark {
            background-color: #214594;
            border: none;
            border-radius: 0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            min-width: 200px;
            padding: 0.5rem 0;
        }

        .dropdown-divider {
            border-color: #444;
            margin: 0.5rem 0;
        }

        .dropdown-menu-dark .dropdown-item {
            color: #ddd;
            padding: 0.6rem 1.5rem;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .dropdown-menu-dark .dropdown-item:hover {
            background-color: #1a3670;
            color: #fcdd01;
            padding-left: 2rem;
        }

        .dropdown-menu-dark .dropdown-item i {
            margin-right: 0.5rem;
            color: #fcdd01;
        }

        /* Dropdown arrow animation */
        .dropdown-toggle::after {
            transition: transform 0.3s ease;
        }

        .nav-item.show .dropdown-toggle::after {
            transform: rotate(180deg);
        }

        /* Search Bar */
        .form-control:focus {
            border-color: #fcdd01;
            box-shadow: 0 0 0 0.2rem rgba(252, 221, 1, 0.25);
        }

        /* Override Bootstrap warning colors */
        .btn-warning {
            background-color: #fcdd01 !important;
            border-color: #fcdd01 !important;
            color: #214594 !important;
        }

        .btn-warning:hover {
            background-color: #e5c801 !important;
            border-color: #e5c801 !important;
            color: #214594 !important;
        }

        .btn-outline-warning {
            border-color: #fcdd01 !important;
            color: #fcdd01 !important;
        }

        .btn-outline-warning:hover {
            background-color: #fcdd01 !important;
            border-color: #fcdd01 !important;
            color: #214594 !important;
        }

        .bg-warning {
            background-color: #fcdd01 !important;
            color: #214594 !important;
        }

        .text-warning {
            color: #fcdd01 !important;
        }

        .badge.bg-warning {
            background-color: #fcdd01 !important;
            color: #214594 !important;
        }

        .bg-danger {
            background-color: #214594 !important;
        }

        .badge.bg-danger {
            background-color: #214594 !important;
            color: #fcdd01 !important;
        }
        
        /* Featured Badge */
        .featured-badge {
            background: linear-gradient(135deg, #fcdd01 0%, #f5c100 100%);
            color: #214594;
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
            background: #fcdd01;
            color: #214594;
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
            background: #fcdd01;
        }
        
        .trending-item {
            border-left: 3px solid #fcdd01;
            padding-left: 1rem;
            margin-bottom: 1rem;
        }
        
        .trending-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fcdd01, #214594);
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
            color: #fcdd01;
        }

        /* ========================================
           RESPONSIVE MEDIA QUERIES
           ======================================== */

        /* Mobile First Base Styles */
        .card-article img {
            height: 180px;
            object-fit: cover;
            width: 100%;
        }

        /* ========================================
           MOBILE PHONES (320px - 575px)
           ======================================== */
        @media (max-width: 575.98px) {
            /* Typography */
            .navbar-brand img {
                height: 42px !important;
            }

            /* Hamburger menu mobile */
            .navbar-toggler {
                padding: 0.4rem 0.6rem;
                border-width: 2px;
            }

            .navbar-toggler-icon {
                width: 1.3rem;
                height: 1.3rem;
            }

            .section-title {
                font-size: 1.2rem !important;
                margin-bottom: 1rem;
            }

            h1, .h1 {
                font-size: 1.5rem;
            }

            h2, .h2 {
                font-size: 1.3rem;
            }

            h3, .h3 {
                font-size: 1.1rem;
            }

            h5, .h5 {
                font-size: 1rem;
            }

            /* Container & Spacing */
            .container {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }

            .row {
                margin-left: -8px;
                margin-right: -8px;
            }

            .col, [class*="col-"] {
                padding-left: 8px;
                padding-right: 8px;
            }

            /* Navbar */
            .navbar {
                padding: 0.5rem 0 !important;
            }

            /* Navbar Position Fix for Mobile */
            body {
                padding-top: 105px !important; /* Adjusted for mobile header height */
            }
            
            .navbar-dark.navbar-fixed-menu {
                top: 61px !important; /* Adjusted for mobile top navbar height */
            }

            .navbar-brand {
                padding: 0;
            }

            /* Mobile menu expanded state */
            .navbar-collapse.show,
            .navbar-collapse.collapsing {
                max-height: calc(100vh - 105px);
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            .navbar-collapse {
                margin-top: 0.5rem;
                background-color: #214594;
                border-radius: 0 0 8px 8px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.3);
            }

            .main-menu {
                padding: 0.5rem 0;
            }

            .main-menu .nav-link {
                padding: 0.75rem 1rem;
                font-size: 0.95rem;
                border-bottom: 1px solid #333;
                display: block;
            }

            .main-menu .nav-link:last-child {
                border-bottom: none;
            }

            .main-menu .nav-item {
                width: 100%;
            }

            .dropdown-menu {
                background-color: #2a2a2a !important;
                border: none;
                border-radius: 0;
                padding-left: 1rem;
            }

            .dropdown-item {
                padding: 0.5rem 1rem !important;
                font-size: 0.85rem;
            }

            .dropdown-divider {
                margin: 0.3rem 0;
            }

            /* Search Bar */
            .form-control {
                min-width: 150px !important;
                max-width: 200px !important;
                font-size: 0.85rem;
            }

            .d-flex.gap-3 {
                gap: 0.5rem !important;
            }

            /* Cards */
            .card-article {
                margin-bottom: 1rem;
            }

            .card-article img {
                height: 160px;
            }

            .card-body {
                padding: 0.75rem !important;
            }

            .card-title {
                font-size: 1rem !important;
                line-height: 1.4;
                margin-bottom: 0.5rem;
            }

            .card-text {
                font-size: 0.85rem;
                line-height: 1.5;
            }

            /* Article Meta */
            .article-meta {
                font-size: 0.75rem !important;
            }

            .category-badge {
                font-size: 0.65rem !important;
                padding: 3px 8px;
            }

            .featured-badge {
                font-size: 0.65rem !important;
                padding: 3px 10px;
            }

            /* Trending Section */
            .trending-number {
                font-size: 1.8rem !important;
                min-width: 35px;
            }

            .trending-item {
                padding-left: 0.75rem;
                margin-bottom: 0.75rem;
            }

            .trending-item h6 {
                font-size: 0.9rem;
            }

            /* Buttons */
            .btn {
                font-size: 0.85rem;
                padding: 0.4rem 0.8rem;
            }

            .btn-sm {
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
            }

            /* Footer */
            footer {
                padding: 2rem 0 1rem !important;
            }

            footer .col-md-4 {
                margin-bottom: 1.5rem !important;
            }

            footer h5, footer h6 {
                font-size: 1rem;
            }

            footer .fs-4 {
                font-size: 1.5rem !important;
            }

            /* Margins & Padding */
            .mt-4, .my-4 {
                margin-top: 1.5rem !important;
            }

            .mb-4, .my-4 {
                margin-bottom: 1.5rem !important;
            }

            .pt-4, .py-4 {
                padding-top: 1.5rem !important;
            }

            .pb-4, .py-4 {
                padding-bottom: 1.5rem !important;
            }

            /* Hide unnecessary elements on mobile */
            .d-none-mobile {
                display: none !important;
            }
        }

        /* ========================================
           TABLETS (576px - 991px)
           ======================================== */
        @media (min-width: 576px) and (max-width: 991.98px) {
            /* Typography */
            .navbar-brand img {
                height: 45px !important;
            }

            .section-title {
                font-size: 1.5rem;
            }

            /* Container */
            .container {
                max-width: 720px;
                padding-left: 15px;
                padding-right: 15px;
            }

            /* Navbar */
            .navbar-toggler {
                display: block;
            }

            .navbar-collapse {
                margin-top: 0.5rem;
            }

            .main-menu .nav-link {
                padding: 0.85rem 1rem;
                font-size: 0.9rem;
            }

            /* Cards */
            .card-article img {
                height: 200px;
            }

            .card-body {
                padding: 1rem;
            }

            .card-title {
                font-size: 1.1rem;
            }

            /* Grid Layout - 2 columns */
            .col-md-6 .card-article img {
                height: 180px;
            }

            /* Trending */
            .trending-number {
                font-size: 2.2rem;
                min-width: 45px;
            }

            /* Search Bar */
            .form-control {
                max-width: 280px !important;
            }

            /* Footer */
            footer .col-md-4 {
                margin-bottom: 2rem;
            }
        }

        /* ========================================
           SMALL DESKTOPS (992px - 1199px)
           ======================================== */
        @media (min-width: 992px) and (max-width: 1199.98px) {
            /* Container */
            .container {
                max-width: 960px;
            }

            /* Navbar */
            /* Removed restrictive nav-link styles to allow larger base styles */

            /* Cards */
            .card-article img {
                height: 200px;
            }

            .col-lg-3 .card-article img {
                height: 160px;
            }

            .col-lg-4 .card-article img {
                height: 180px;
            }

            /* Typography */
            .section-title {
                font-size: 1.6rem;
            }

            .card-title {
                font-size: 1.05rem;
            }

            /* Search */
            .form-control {
                max-width: 300px !important;
            }
        }

        /* ========================================
           LARGE DESKTOPS (1200px+)
           ======================================== */
        @media (min-width: 1200px) {
            /* Container */
            .container {
                max-width: 1200px;
            }

            /* Navbar */
            /* Removed restrictive nav-link styles to allow larger base styles */

            /* Cards */
            .card-article img {
                height: 220px;
            }

            .col-lg-3 .card-article img {
                height: 180px;
            }

            .col-lg-4 .card-article img {
                height: 200px;
            }

            /* Typography */
            .section-title {
                font-size: 1.75rem;
            }

            /* Search */
            .form-control {
                max-width: 350px !important;
            }

            /* Hover Effects - Only on Desktop */
            .card-article:hover {
                transform: translateY(-5px);
            }

            .main-menu .nav-link:hover {
                background-color: #333;
            }
        }

        /* ========================================
           EXTRA LARGE DESKTOPS (1400px+)
           ======================================== */
        @media (min-width: 1400px) {
            .container {
                max-width: 1320px;
            }

            .card-article img {
                height: 240px;
            }

            .col-lg-3 .card-article img {
                height: 200px;
            }

            .section-title {
                font-size: 2rem;
            }
        }

        /* ========================================
           LANDSCAPE ORIENTATION (Tablets & Phones)
           ======================================== */
        @media (max-width: 991.98px) and (orientation: landscape) {
            .card-article img {
                height: 150px;
            }

            .navbar {
                padding: 0.25rem 0 !important;
            }

            .main-menu .nav-link {
                padding: 0.6rem 0.8rem;
            }
        }

        /* ========================================
           PRINT STYLES
           ======================================== */
        @media print {
            .navbar,
            footer,
            .btn,
            #themeToggle {
                display: none !important;
            }

            .container {
                max-width: 100%;
            }

            .card-article {
                page-break-inside: avoid;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    {{-- Top Navbar (Header) --}}
    <nav class="navbar navbar-light bg-white py-3 navbar-fixed-top" style="border-bottom: 3px solid #fcdd01;">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('LOGO_SALUT_.png') }}" alt="SALUT Logo">
            </a>
            <div class="d-flex align-items-center gap-3">
                <form action="{{ route('search') }}" method="GET" class="d-flex">
                    <input class="form-control" type="search" name="q" placeholder="Cari tokoh, topik atau peristiwa" value="{{ request('q') }}" style="max-width: 500px; min-width: 350px; width: 100%; border-radius: 25px; padding: 0.6rem 1.2rem; font-size: 0.95rem;">
                    <button class="btn btn-link" type="submit" style="margin-left: -40px; color: #214594;">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                <button id="themeToggle" class="btn btn-link p-0" style="font-size: 1.3rem; color: #214594;">
                    <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
                </button>
            </div>
        </div>
    </nav>

    {{-- Main Menu Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark py-0 navbar-fixed-menu" style="background-color: #214594;">
        <div class="container">
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainMenu">
                <ul class="navbar-nav me-auto main-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item mega-dropdown">
                        <a class="nav-link" href="#">
                            Profil <i class="bi bi-chevron-down ms-1" style="font-size: 0.85rem;"></i>
                        </a>
                        <div class="mega-dropdown-menu">
                            <div class="row g-0">
                                <div class="col-md-5">
                                    <div class="mega-section mega-image">
                                        <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?w=600" alt="Universitas Terbuka">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="mega-section">
                                        <h5>SALUT Samarinda</h5>
                                        <p class="small text-muted mb-3">Sentra Layanan Universitas Terbuka Kota Samarinda</p>
                                        <div class="mega-links">
                                            <a href="{{ route('page.show', 'kepala-dan-staf') }}" class="mega-link">
                                                <i class="bi bi-person-circle"></i>
                                                <span>Direktur</span>
                                            </a>
                                            <a href="{{ route('page.show', 'kepala-dan-staf') }}" class="mega-link">
                                                <i class="bi bi-people"></i>
                                                <span>Manajer Tata Usaha</span>
                                            </a>
                                            <a href="{{ route('page.show', 'kepala-dan-staf') }}" class="mega-link">
                                                <i class="bi bi-megaphone"></i>
                                                <span>Manajer Marketing dan Registrasi</span>
                                            </a>
                                            <a href="{{ route('page.show', 'manajer-pembelajaran-ujian') }}" class="mega-link">
                                                <i class="bi bi-book"></i>
                                                <span>Manajer Pembelajaran dan Ujian</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="d-flex gap-3">
                                        <a href="{{ route('page.show', 'visi-misi') }}" class="mega-link" style="flex: 1; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1rem;">
                                            <i class="bi bi-archive"></i>
                                            <span>Visi dan Misi</span>
                                        </a>
                                        <a href="{{ route('page.show', 'struktur-organisasi') }}" class="mega-link" style="flex: 1; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1rem;">
                                            <i class="bi bi-diagram-3"></i>
                                            <span>Struktur Organisasi</span>
                                        </a>
                                        <a href="{{ route('page.show', 'sejarah') }}" class="mega-link" style="flex: 1; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1rem;">
                                            <i class="bi bi-building"></i>
                                            <span>Sejarah</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item mega-dropdown">
                        <a class="nav-link" href="#">
                            Akademik <i class="bi bi-chevron-down ms-1" style="font-size: 0.75rem;"></i>
                        </a>
                        <div class="mega-dropdown-menu" style="min-width: 400px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mega-section">
                                        <a href="{{ route('page.show', 'program-studi') }}" class="mega-link" style="flex: 1; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1rem; margin-bottom: 0.5rem;">
                                            <i class="bi bi-mortarboard"></i>
                                            <span>Program Studi</span>
                                        </a>
                                        <a href="{{ route('page.show', 'fakultas') }}" class="mega-link" style="flex: 1; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1rem;">
                                            <i class="bi bi-building"></i>
                                            <span>Fakultas</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item mega-dropdown d-none">
                        <a class="nav-link" href="#">
                            Akademik OLD <i class="bi bi-chevron-down ms-1" style="font-size: 0.75rem;"></i>
                        </a>
                        <div class="mega-dropdown-menu" style="min-width: 900px;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mega-section">
                                        <h6 class="mb-3" style="color: #214594; font-weight: 600;">Program Studi</h6>
                                        <a href="#" class="btn btn-primary w-100 mb-2" style="background-color: #214594; border: none; text-align: left; padding: 0.75rem 1rem;">
                                            <i class="bi bi-mortarboard me-2"></i> Diploma (D3 & D4) - 2 Program
                                        </a>
                                        <a href="#" class="btn btn-primary w-100 mb-2" style="background-color: #214594; border: none; text-align: left; padding: 0.75rem 1rem;">
                                            <i class="bi bi-book me-2"></i> Sarjana (S1) - 36 Program
                                        </a>
                                        <a href="#" class="btn btn-primary w-100 mb-2" style="background-color: #214594; border: none; text-align: left; padding: 0.75rem 1rem;">
                                            <i class="bi bi-journal-text me-2"></i> Magister (S2) - 9 Program
                                        </a>
                                        <a href="#" class="btn btn-primary w-100 mb-2" style="background-color: #214594; border: none; text-align: left; padding: 0.75rem 1rem;">
                                            <i class="bi bi-mortarboard-fill me-2"></i> Doktoral (S3) - 2 Program
                                        </a>
                                        <a href="#" class="btn btn-primary w-100 mb-2" style="background-color: #214594; border: none; text-align: left; padding: 0.75rem 1rem;">
                                            <i class="bi bi-person-workspace me-2"></i> Program Profesi - Pendidikan Profesi Guru
                                        </a>
                                        <a href="#" class="btn btn-primary w-100" style="background-color: #214594; border: none; text-align: left; padding: 0.75rem 1rem;">
                                            <i class="bi bi-award me-2"></i> Program Sertifikat (MOOCs, BIPA, PMKM)
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mega-section">
                                        <h6 class="mb-3" style="color: #214594; font-weight: 600;">Fakultas</h6>
                                        <a href="#" class="mega-link">
                                            <i class="bi bi-building"></i>
                                            <span>Fakultas Keguruan dan Ilmu Pendidikan (FKIP)</span>
                                        </a>
                                        <a href="#" class="mega-link">
                                            <i class="bi bi-building"></i>
                                            <span>Fakultas Ekonomi dan Bisnis (FEB)</span>
                                        </a>
                                        <a href="#" class="mega-link">
                                            <i class="bi bi-building"></i>
                                            <span>Fakultas Sains dan Teknologi (FST)</span>
                                        </a>
                                        <a href="#" class="mega-link">
                                            <i class="bi bi-building"></i>
                                            <span>Fakultas Hukum, Ilmu Sosial dan Ilmu Politik (FHISIP)</span>
                                        </a>
                                        <a href="#" class="mega-link">
                                            <i class="bi bi-building"></i>
                                            <span>Sekolah Pascasarjana (SPs)</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mega-section">
                                        <h6 class="mb-3" style="color: #214594; font-weight: 600;">Layanan Akademik</h6>
                                        <a href="#" class="mega-link">
                                            <i class="bi bi-calendar-event"></i>
                                            <span>Kalender Akademik</span>
                                        </a>
                                        <a href="#" class="mega-link">
                                            <i class="bi bi-book"></i>
                                            <span>Katalog Digital</span>
                                        </a>
                                        <a href="#" class="mega-link">
                                            <i class="bi bi-pencil-square"></i>
                                            <span>Akreditasi Program Studi</span>
                                        </a>
                                        <a href="#" class="mega-link">
                                            <i class="bi bi-file-earmark-text"></i>
                                            <span>Legalisir Ijazah Online</span>
                                        </a>
                                        <a href="#" class="mega-link">
                                            <i class="bi bi-clipboard-check"></i>
                                            <span>Surat Keterangan Online</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#section-mahasiswa" onclick="scrollToSection(event, 'section-mahasiswa')">
                            Mahasiswa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#footer" onclick="scrollToSection(event, 'footer')">Kontak</a>
                    </li>
                    
                    {{-- Dynamic Menu from Database --}}
                    @if(isset($navbarPages) && $navbarPages->count() > 0)
                        @foreach($navbarPages as $page)
                            @if($page->menu_type === 'dropdown' && $page->dropdown_items && count($page->dropdown_items) > 0)
                                {{-- Dropdown Menu Type --}}
                                <li class="nav-item mega-dropdown">
                                    <a class="nav-link" href="#">
                                        @if($page->navbar_icon)<i class="{{ $page->navbar_icon }} me-1"></i>@endif
                                        {{ $page->title }} <i class="bi bi-chevron-down ms-1" style="font-size: 0.75rem;"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-dark">
                                        @foreach($page->dropdown_items as $item)
                                            @if(isset($item['slug']) && $item['slug'])
                                                {{-- New format with slug --}}
                                                <a class="dropdown-item" href="{{ route('submenu.show', [$page->slug, $item['slug']]) }}">
                                                    @if(isset($item['icon']) && $item['icon'])
                                                        <i class="{{ $item['icon'] }}"></i>
                                                    @endif
                                                    {{ $item['label'] }}
                                                </a>
                                            @else
                                                {{-- Old format without slug (anchor link) --}}
                                                <a class="dropdown-item" href="{{ route('page.show', $page->slug) }}#{{ \Illuminate\Support\Str::slug($item['label']) }}">
                                                    @if(isset($item['icon']) && $item['icon'])
                                                        <i class="{{ $item['icon'] }}"></i>
                                                    @endif
                                                    {{ $item['label'] }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </li>
                            @else
                                @php
                                    $children = \App\Models\Page::navbarChildren($page->slug)->get();
                                @endphp
                                
                                @if($children->count() > 0)
                                    {{-- Menu with child pages (old style) --}}
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            @if($page->navbar_icon)<i class="{{ $page->navbar_icon }} me-1"></i>@endif
                                            {{ $page->title }}
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-dark">
                                            <li><a class="dropdown-item" href="{{ route('page.show', $page->slug) }}">{{ $page->title }}</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            @foreach($children as $child)
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('page.show', $child->slug) }}">
                                                        @if($child->navbar_icon)<i class="{{ $child->navbar_icon }} me-1"></i>@endif
                                                        {{ $child->title }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    {{-- Simple menu item --}}
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('page/'.$page->slug) ? 'active' : '' }}" href="{{ route('page.show', $page->slug) }}">
                                            @if($page->navbar_icon)<i class="{{ $page->navbar_icon }} me-1"></i>@endif
                                            {{ $page->title }}
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="mt-5" id="footer">
        <div class="container">
            {{-- Footer Top Section --}}
            <div class="row py-4">
                {{-- Brand & About --}}
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <div class="footer-brand mb-3">
                        <img src="{{ asset('LOGO_SALUT_.png') }}" alt="SALUT Logo" style="height: 50px; filter: brightness(0) invert(1);">
                    </div>
                    <p class="text-secondary mb-3" style="font-size: 0.9rem; line-height: 1.7;">
                        Sentra Layanan Universitas Terbuka (SALUT) UT Kota Samarinda - Melayani pendaftaran, konsultasi akademik, dan informasi seputar Universitas Terbuka.
                    </p>
                    {{-- Social Icons --}}
                    <div class="d-flex gap-2">
                        <a href="https://www.instagram.com/salutsamarinda_univterbuka" target="_blank" class="footer-social-icon">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://www.facebook.com/salut.ut.samarinda" target="_blank" class="footer-social-icon">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.tiktok.com/@salut_ut_samarinda" target="_blank" class="footer-social-icon">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <a href="https://wa.me/6282160040017" target="_blank" class="footer-social-icon">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>
                
                {{-- Quick Contact --}}
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <h6 class="footer-title">Hubungi Kami</h6>
                    <div class="footer-contact-list">
                        <a href="https://wa.me/6282160040017" target="_blank" class="footer-contact-item">
                            <div class="footer-contact-icon">
                                <i class="bi bi-headset"></i>
                            </div>
                            <div>
                                <span class="footer-contact-label">Konsultasi Perkuliahan</span>
                                <span class="footer-contact-value">0821-6004-0017</span>
                            </div>
                        </a>
                        <a href="https://wa.me/6285247371117" target="_blank" class="footer-contact-item footer-contact-highlight">
                            <div class="footer-contact-icon">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <div>
                                <span class="footer-contact-label">PMB (Pendaftaran)</span>
                                <span class="footer-contact-value">0852-4737-1117</span>
                            </div>
                        </a>
                    </div>
                </div>
                
                {{-- Location & Hours --}}
                <div class="col-lg-4 col-md-12">
                    <h6 class="footer-title">Lokasi & Jam Operasional</h6>
                    <div class="footer-info-card">
                        <div class="footer-info-item">
                            <i class="bi bi-geo-alt-fill"></i>
                            <div>
                                <strong>Alamat</strong>
                                <p>Jl. Pramuka 6 Ruko No.3, Gn. Kelua, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur 75125</p>
                                <small class="text-warning">(Depan Kopiria Pramuka)</small>
                            </div>
                        </div>
                        <div class="footer-info-item">
                            <i class="bi bi-clock-fill"></i>
                            <div>
                                <strong>Jam Buka</strong>
                                <p class="mb-0">Senin - Minggu</p>
                                <span class="text-warning">08.00 - 21.00 WITA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Footer Bottom --}}
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-0">&copy; {{ date('Y') }} SALUT UT Samarinda. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                        <a href="https://ut.ac.id" target="_blank" class="footer-link">Universitas Terbuka</a>
                        <span class="mx-2 text-secondary">|</span>
                        <a href="{{ route('page.show', 'visi-misi') }}" class="footer-link">Visi & Misi</a>
                        <span class="mx-2 text-secondary">|</span>
                        <a href="#" class="footer-link">Kebijakan Privasi</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <style>
        /* Footer Styles */
        .footer-brand img {
            transition: opacity 0.3s ease;
        }
        
        .footer-social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            color: #fff;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        
        .footer-social-icon:hover {
            background: #fcdd01;
            color: #214594;
            transform: translateY(-3px);
        }
        
        .footer-title {
            color: #fff;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #fcdd01;
            display: inline-block;
        }
        
        .footer-contact-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .footer-contact-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: rgba(255,255,255,0.05);
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer-contact-item:hover {
            background: rgba(252, 221, 1, 0.1);
            transform: translateX(5px);
        }
        
        .footer-contact-icon {
            width: 40px;
            height: 40px;
            background: #214594;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fcdd01;
            font-size: 1rem;
        }
        
        .footer-contact-label {
            display: block;
            font-size: 0.7rem;
            color: #999;
        }
        
        .footer-contact-value {
            display: block;
            color: #fff;
            font-weight: 500;
            font-size: 0.8rem;
        }
        
        .footer-contact-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
        }
        
        .footer-contact-item-sm {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 0.75rem;
            background: rgba(255,255,255,0.05);
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer-contact-item-sm:hover {
            background: rgba(252, 221, 1, 0.15);
            transform: translateY(-2px);
        }
        
        .footer-contact-item-sm i {
            color: #25D366;
            font-size: 1.1rem;
        }
        
        .footer-contact-item-sm .bi-person-badge {
            color: #fcdd01;
        }
        
        .footer-contact-item-sm .bi-broadcast {
            color: #00a8ff;
        }
        
        .footer-contact-highlight {
            background: rgba(252, 221, 1, 0.1);
            border: 1px solid rgba(252, 221, 1, 0.3);
        }
        
        .footer-info-card {
            background: rgba(255,255,255,0.05);
            border-radius: 12px;
            padding: 1.25rem;
        }
        
        .footer-info-item {
            display: flex;
            gap: 1rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .footer-info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        
        .footer-info-item i {
            color: #fcdd01;
            font-size: 1.25rem;
            margin-top: 0.25rem;
        }
        
        .footer-info-item strong {
            display: block;
            color: #fff;
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
        }
        
        .footer-info-item p {
            color: #aaa;
            font-size: 0.8rem;
            margin-bottom: 0.25rem;
            line-height: 1.5;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding: 1.25rem 0;
            margin-top: 1rem;
            font-size: 0.85rem;
            color: #888;
        }
        
        .footer-link {
            color: #aaa;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-link:hover {
            color: #fcdd01;
        }
        
        @media (max-width: 767.98px) {
            .footer-info-card {
                margin-top: 0.5rem;
            }
            
            .footer-bottom {
                text-align: center;
            }
            
            .footer-bottom .col-md-6 {
                margin-bottom: 0.5rem;
            }
        }
    </style>

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Dropdown Toggle Script --}}
    <script>
        // Scroll to section function
        function scrollToSection(event, sectionId) {
            event.preventDefault();
            const section = document.getElementById(sectionId);
            if (section) {
                // Close mobile menu first if open
                const mainMenu = document.getElementById('mainMenu');
                const bsCollapse = bootstrap.Collapse.getInstance(mainMenu);
                if (bsCollapse && mainMenu.classList.contains('show')) {
                    bsCollapse.hide();
                }
                
                // Wait a bit for menu to close then scroll
                setTimeout(() => {
                    const navbarHeight = document.querySelector('.navbar-fixed-menu').offsetHeight + 10;
                    const sectionTop = section.offsetTop - navbarHeight;
                    window.scrollTo({
                        top: sectionTop,
                        behavior: 'smooth'
                    });
                }, 300);
            }
        }

        // Toggle mega dropdown on click (for mobile)
        document.addEventListener('DOMContentLoaded', function() {
            const megaDropdowns = document.querySelectorAll('.mega-dropdown > .nav-link');
            
            megaDropdowns.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    // Only use click toggle on mobile
                    if (window.innerWidth < 992) {
                        event.preventDefault();
                        event.stopPropagation();
                        
                        const parentLi = this.closest('.mega-dropdown');
                        const dropdownMenu = parentLi.querySelector('.mega-dropdown-menu');
                        const chevron = this.querySelector('.bi-chevron-down, .bi-chevron-up');
                        
                        // Close all other mega dropdowns
                        document.querySelectorAll('.mega-dropdown').forEach(function(item) {
                            if (item !== parentLi) {
                                item.classList.remove('show');
                                const menu = item.querySelector('.mega-dropdown-menu');
                                if (menu) menu.style.display = 'none';
                                const otherChevron = item.querySelector('.bi-chevron-up');
                                if (otherChevron) {
                                    otherChevron.classList.remove('bi-chevron-up');
                                    otherChevron.classList.add('bi-chevron-down');
                                }
                            }
                        });
                        
                        // Toggle current dropdown
                        const isOpen = parentLi.classList.contains('show');
                        if (isOpen) {
                            parentLi.classList.remove('show');
                            dropdownMenu.style.display = 'none';
                            if (chevron) {
                                chevron.classList.remove('bi-chevron-up');
                                chevron.classList.add('bi-chevron-down');
                            }
                        } else {
                            parentLi.classList.add('show');
                            dropdownMenu.style.display = 'block';
                            if (chevron) {
                                chevron.classList.remove('bi-chevron-down');
                                chevron.classList.add('bi-chevron-up');
                            }
                        }
                    }
                });
            });
        });

        // Toggle dropdown on click (for regular dropdowns)
        function toggleDropdown(event, element) {
            event.preventDefault();
            event.stopPropagation();
            
            const parentLi = element.closest('.nav-item');
            const dropdownMenu = parentLi.querySelector('.dropdown-menu');
            
            // Close all other dropdowns
            document.querySelectorAll('.nav-item.show').forEach(item => {
                if (item !== parentLi) {
                    item.classList.remove('show');
                    item.querySelector('.dropdown-menu')?.classList.remove('show');
                }
            });
            
            // Toggle current dropdown
            parentLi.classList.toggle('show');
            dropdownMenu?.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.nav-item')) {
                document.querySelectorAll('.nav-item.show').forEach(item => {
                    item.classList.remove('show');
                    item.querySelector('.dropdown-menu')?.classList.remove('show');
                });
            }
        });

        // On desktop, use hover instead of click
        if (window.innerWidth >= 992) {
            document.querySelectorAll('.mega-dropdown').forEach(dropdown => {
                dropdown.addEventListener('mouseenter', function() {
                    this.classList.add('show');
                    this.querySelector('.dropdown-menu')?.classList.add('show');
                });
                
                dropdown.addEventListener('mouseleave', function() {
                    this.classList.remove('show');
                    this.querySelector('.dropdown-menu')?.classList.remove('show');
                });
            });
        }

        // Handle responsive adjustments on window resize without page reload
        let resizeTimer;
        let lastWidth = window.innerWidth;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                const currentWidth = window.innerWidth;
                // Hanya update jika lebar berubah secara signifikan (bukan karena browser bar muncul/hilang)
                if (Math.abs(currentWidth - lastWidth) > 100) {
                    // Re-attach event listeners jika perlu
                    if (currentWidth >= 992) {
                        document.querySelectorAll('.mega-dropdown').forEach(dropdown => {
                            dropdown.addEventListener('mouseenter', function() {
                                this.classList.add('show');
                                this.querySelector('.dropdown-menu')?.classList.add('show');
                            });
                            dropdown.addEventListener('mouseleave', function() {
                                this.classList.remove('show');
                                this.querySelector('.dropdown-menu')?.classList.remove('show');
                            });
                        });
                    }
                    lastWidth = currentWidth;
                }
            }, 250);
        });
    </script>
    
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

    {{-- Navbar Scroll Logic --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let lastScrollTop = 0;
            let ticking = false;
            const topNavbar = document.querySelector('.navbar-fixed-top');
            const menuNavbar = document.querySelector('.navbar-fixed-menu');
            const mainMenu = document.getElementById('mainMenu');
            
            // Calculate heights
            const topNavHeight = topNavbar.offsetHeight;
            const menuNavHeight = menuNavbar.offsetHeight;
            const totalHeight = topNavHeight + menuNavHeight;
            
            // Set transition for smooth animation
            topNavbar.style.transition = 'top 0.3s ease-in-out';
            menuNavbar.style.transition = 'top 0.3s ease-in-out';

            function updateNavbar() {
                // Jangan sembunyikan navbar saat menu mobile terbuka
                if (mainMenu && mainMenu.classList.contains('show')) {
                    ticking = false;
                    return;
                }

                let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (scrollTop > lastScrollTop && scrollTop > 50) {
                    // Scroll Down - Hide BOTH navbars
                    topNavbar.style.top = `-${topNavHeight}px`;
                    menuNavbar.style.top = `-${menuNavHeight}px`;
                } else {
                    // Scroll Up or at top - Show both Navbars
                    topNavbar.style.top = '0';
                    menuNavbar.style.top = `${topNavHeight}px`;
                }
                
                lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
                ticking = false;
            }

            window.addEventListener('scroll', function() {
                if (!ticking) {
                    window.requestAnimationFrame(updateNavbar);
                    ticking = true;
                }
            });

            // Lock body scroll saat menu mobile terbuka
            if (mainMenu) {
                mainMenu.addEventListener('show.bs.collapse', function() {
                    document.body.classList.add('menu-open');
                    // Pastikan navbar tetap di posisi normal saat menu terbuka
                    topNavbar.style.top = '0';
                    menuNavbar.style.top = `${topNavHeight}px`;
                });
                mainMenu.addEventListener('hide.bs.collapse', function() {
                    document.body.classList.remove('menu-open');
                });
            }
            
            // Initial state
            menuNavbar.style.top = `${topNavHeight}px`;
        });
    </script>
    
    @stack('scripts')
</body>
</html>
