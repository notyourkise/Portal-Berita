@extends('frontend.layouts.app')

@section('title', $title . ' - ' . $parentPage->title)
@section('meta_description', 'Informasi tentang ' . $title . ' di SALUT UT Samarinda')

@section('content')
<div class="container py-4 py-md-5">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('page.show', $parentPage->slug) }}">{{ $parentPage->title }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
        </ol>
    </nav>

    {{-- Page Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center mb-3">
                @if($icon)
                    <div class="me-3" style="font-size: 2.5rem; color: #214594;">
                        <i class="{{ $icon }}"></i>
                    </div>
                @endif
                <div>
                    <h1 class="mb-1" style="color: #214594; font-weight: 700;">{{ $title }}</h1>
                    <p class="text-muted mb-0">{{ $parentPage->title }}</p>
                </div>
            </div>
            <hr style="border-top: 3px solid #ffc107; width: 100px; opacity: 1;">
        </div>
    </div>

    {{-- Page Content --}}
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    @if($content)
                        <div class="page-content">
                            {!! $content !!}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Konten untuk halaman ini sedang dalam proses pengembangan.
                            <br>
                            <small>Silakan hubungi admin untuk informasi lebih lanjut.</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-list-ul me-2"></i>
                        {{ $parentPage->title }}
                    </h6>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($parentPage->dropdown_items as $item)
                        <a href="{{ route('submenu.show', [$parentPage->slug, $item['slug']]) }}" 
                           class="list-group-item list-group-item-action {{ $item['slug'] === $submenuItem['slug'] ? 'active' : '' }}">
                            @if(isset($item['icon']) && $item['icon'])
                                <i class="{{ $item['icon'] }} me-2"></i>
                            @endif
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Contact Card --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-question-circle" style="font-size: 3rem; color: #214594;"></i>
                    <h6 class="mt-3 mb-2">Butuh Bantuan?</h6>
                    <p class="text-muted small mb-3">Hubungi kami untuk informasi lebih lanjut</p>
                    <a href="https://wa.me/6282160040017" target="_blank" class="btn btn-success btn-sm">
                        <i class="bi bi-whatsapp me-1"></i> WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-content {
    font-size: 1rem;
    line-height: 1.8;
    color: #333;
}

.page-content h1,
.page-content h2,
.page-content h3,
.page-content h4,
.page-content h5,
.page-content h6 {
    color: #214594;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}

.page-content p {
    margin-bottom: 1rem;
}

.page-content ul,
.page-content ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}

.page-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
}

.page-content table {
    width: 100%;
    margin-bottom: 1rem;
    border-collapse: collapse;
}

.page-content table th,
.page-content table td {
    padding: 0.75rem;
    border: 1px solid #dee2e6;
}

.page-content table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.page-content blockquote {
    padding: 1rem 1.5rem;
    margin: 1rem 0;
    border-left: 4px solid #214594;
    background-color: #f8f9fa;
    font-style: italic;
}

.page-content a {
    color: #214594;
    text-decoration: underline;
}

.page-content a:hover {
    color: #ffc107;
}

.breadcrumb {
    background-color: #f8f9fa;
    padding: 0.75rem 1rem;
    border-radius: 0.375rem;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: #6c757d;
}

.list-group-item.active {
    background-color: #214594;
    border-color: #214594;
}

.list-group-item:hover:not(.active) {
    background-color: #f8f9fa;
}
</style>
@endsection
