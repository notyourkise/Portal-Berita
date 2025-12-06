@extends('frontend.layouts.app')

@section('title', $page->title . ' - SALUT UT Samarinda')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Page Header --}}
            <div class="mb-4">
                <h1 class="display-5 fw-bold" style="color: #214594;">{{ $page->title }}</h1>
                <div class="border-bottom border-warning border-3 mb-4" style="width: 80px;"></div>
            </div>

            {{-- Dropdown Menu Navigation (if menu_type is dropdown) --}}
            @if($page->menu_type === 'dropdown' && $page->dropdown_items && count($page->dropdown_items) > 0)
                <div class="dropdown-nav-pills mb-4">
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($page->dropdown_items as $index => $item)
                            <a href="#{{ \Illuminate\Support\Str::slug($item['label']) }}" 
                               class="btn btn-outline-primary dropdown-nav-btn"
                               onclick="scrollToDropdownSection(event, '{{ \Illuminate\Support\Str::slug($item['label']) }}')">
                                @if(isset($item['icon']) && $item['icon'])
                                    <i class="{{ $item['icon'] }} me-1"></i>
                                @endif
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Dropdown Sections --}}
                @foreach($page->dropdown_items as $index => $item)
                    <div id="{{ \Illuminate\Support\Str::slug($item['label']) }}" class="dropdown-section mb-5 p-4 bg-white rounded shadow-sm">
                        <h2 class="section-title">
                            @if(isset($item['icon']) && $item['icon'])
                                <i class="{{ $item['icon'] }} me-2"></i>
                            @endif
                            {{ $item['label'] }}
                        </h2>
                        <div class="section-content">
                            <p class="text-muted">Konten untuk section {{ $item['label'] }} akan ditampilkan di sini.</p>
                            <p>Anda dapat mengedit konten ini dari admin panel Filament.</p>
                        </div>
                    </div>
                @endforeach
            @else
                {{-- Regular Page Content --}}
                <div class="page-content bg-white p-4 rounded shadow-sm">
                    <div class="content-text" style="line-height: 1.8; font-size: 1.05rem;">
                        {!! $page->content !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function scrollToDropdownSection(event, sectionId) {
        event.preventDefault();
        const section = document.getElementById(sectionId);
        if (section) {
            const navbarHeight = document.querySelector('.navbar-fixed-menu').offsetHeight + 
                                 document.querySelector('.navbar-fixed-top').offsetHeight + 20;
            const sectionTop = section.offsetTop - navbarHeight;
            window.scrollTo({
                top: sectionTop,
                behavior: 'smooth'
            });
            
            // Highlight active button
            document.querySelectorAll('.dropdown-nav-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
        }
    }
    
    // Auto-highlight on scroll
    window.addEventListener('scroll', function() {
        const sections = document.querySelectorAll('.dropdown-section');
        const navbarHeight = document.querySelector('.navbar-fixed-menu')?.offsetHeight + 
                            document.querySelector('.navbar-fixed-top')?.offsetHeight + 20;
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop - navbarHeight - 50;
            const sectionBottom = sectionTop + section.offsetHeight;
            const scrollPos = window.scrollY;
            
            if (scrollPos >= sectionTop && scrollPos < sectionBottom) {
                const sectionId = section.getAttribute('id');
                document.querySelectorAll('.dropdown-nav-btn').forEach(btn => {
                    btn.classList.remove('active');
                    if (btn.getAttribute('href') === '#' + sectionId) {
                        btn.classList.add('active');
                    }
                });
            }
        });
    });
</script>
@endpush

@push('styles')
<style>
    .dropdown-nav-pills {
        position: sticky;
        top: 170px;
        z-index: 100;
        background: white;
        padding: 1rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .dropdown-nav-btn {
        border-color: #214594;
        color: #214594;
        transition: all 0.3s ease;
    }
    
    .dropdown-nav-btn:hover,
    .dropdown-nav-btn.active {
        background-color: #214594;
        color: white;
        border-color: #214594;
    }
    
    .dropdown-section {
        scroll-margin-top: 200px;
    }
    
    .dropdown-section .section-title {
        color: #214594;
        font-weight: 700;
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid #fcdd01;
    }
    
    .dropdown-section .section-content {
        line-height: 1.8;
        font-size: 1.05rem;
    }
    
    .page-content {
        background: #ffffff;
    }
    
    .content-text {
        color: #333;
    }
    
    .content-text h2 {
        color: #214594;
        font-weight: 700;
        font-size: 1.75rem;
        margin-top: 2rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 3px solid #fcdd01;
    }
    
    .content-text h2:first-child {
        margin-top: 0;
    }
    
    .content-text h3 {
        color: #214594;
        font-weight: 600;
        font-size: 1.4rem;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
    }
    
    .content-text h4 {
        color: #214594;
        font-weight: 600;
        font-size: 1.2rem;
        margin-top: 1.25rem;
        margin-bottom: 0.75rem;
    }
    
    .content-text p {
        margin-bottom: 1rem;
        text-align: justify;
    }
    
    .content-text ul,
    .content-text ol {
        margin-left: 2rem;
        margin-bottom: 1.5rem;
    }
    
    .content-text ul li,
    .content-text ol li {
        margin-bottom: 0.75rem;
        line-height: 1.8;
    }
    
    .content-text ol {
        counter-reset: item;
    }
    
    .content-text ol li {
        display: block;
        position: relative;
        padding-left: 0.5rem;
    }
    
    .content-text ul li::marker {
        color: #214594;
        font-size: 1.2em;
    }
    
    .content-text ol li::marker {
        color: #214594;
        font-weight: 700;
    }
    
    .content-text strong {
        color: #214594;
        font-weight: 700;
    }
    
    .content-text a {
        color: #214594;
        text-decoration: underline;
    }
    
    .content-text a:hover {
        color: #fcdd01;
    }
</style>
@endpush
@endsection
