@extends('frontend.layouts.app')

@section('title', 'Kegiatan Mahasiswa - SALUT UT Samarinda')
@section('meta_description', 'Berita dan informasi seputar kegiatan mahasiswa Universitas Terbuka Samarinda')

@section('content')
<div class="container my-5">
    {{-- Page Header --}}
    <div class="mb-4">
        <div class="d-flex align-items-center mb-3">
            <div class="bg-primary p-3 rounded me-3" style="background-color: #214594 !important;">
                <i class="bi bi-people-fill text-white" style="font-size: 2rem;"></i>
            </div>
            <div>
                <h1 class="display-5 fw-bold mb-0" style="color: #214594;">Kegiatan Mahasiswa</h1>
                <p class="text-muted mb-0">Berita dan Informasi Mahasiswa UT Samarinda</p>
            </div>
        </div>
        <div class="border-bottom border-3 mb-4" style="border-color: #fcdd01 !important; width: 120px;"></div>
    </div>

    {{-- Info Banner --}}
    <div class="alert alert-info border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #214594 0%, #3a5ba8 100%);">
        <div class="d-flex align-items-center">
            <i class="bi bi-info-circle-fill text-white me-3" style="font-size: 2rem;"></i>
            <div class="text-white">
                <h5 class="mb-1 fw-bold">Portal Informasi Mahasiswa</h5>
                <p class="mb-0">Dapatkan update terbaru seputar kegiatan, prestasi, dan informasi penting untuk mahasiswa UT Samarinda</p>
            </div>
        </div>
    </div>

    @if($articles->count() > 0)
        {{-- Articles Grid --}}
        <div class="row g-4">
            @foreach($articles as $article)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        @if($article->cover_image)
                            <img src="{{ Storage::url($article->cover_image_medium ?? $article->cover_image) }}" 
                                 class="card-img-top" 
                                 alt="{{ $article->title }}"
                                 style="height: 220px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 220px; background: linear-gradient(135deg, #214594 0%, #3a5ba8 100%) !important;">
                                <i class="bi bi-people text-white" style="font-size: 4rem; opacity: 0.3;"></i>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge me-2" style="background-color: #214594;">
                                    <i class="bi bi-people me-1"></i> Mahasiswa
                                </span>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $article->published_at->format('d M Y') }}
                                </small>
                            </div>
                            
                            <h5 class="card-title">
                                <a href="{{ route('article.show', $article->slug) }}" 
                                   class="text-decoration-none text-dark hover-primary">
                                    {{ Str::limit($article->title, 60) }}
                                </a>
                            </h5>
                            
                            @if($article->excerpt)
                                <p class="card-text text-muted small">
                                    {{ Str::limit($article->excerpt, 100) }}
                                </p>
                            @endif
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-eye me-1"></i> {{ number_format($article->views_count) }} views
                                </small>
                                <a href="{{ route('article.show', $article->slug) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($articles->hasPages())
            <div class="mt-5">
                {{ $articles->links() }}
            </div>
        @endif
    @else
        {{-- Empty State --}}
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="bi bi-newspaper" style="font-size: 5rem; color: #e0e0e0;"></i>
            </div>
            <h3 class="text-muted mb-3">Belum Ada Berita Mahasiswa</h3>
            <p class="text-muted mb-4">Berita dan informasi kegiatan mahasiswa akan ditampilkan di sini</p>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="bi bi-house-door me-2"></i> Kembali ke Beranda
            </a>
        </div>
    @endif
</div>

@push('styles')
<style>
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(33, 69, 148, 0.15) !important;
    }
    
    .hover-primary:hover {
        color: #214594 !important;
    }
    
    .btn-outline-primary {
        border-color: #214594;
        color: #214594;
    }
    
    .btn-outline-primary:hover {
        background-color: #214594;
        border-color: #214594;
        color: white;
    }
    
    .btn-primary {
        background-color: #214594;
        border-color: #214594;
    }
    
    .btn-primary:hover {
        background-color: #1a3770;
        border-color: #1a3770;
    }
</style>
@endpush
@endsection
