@extends('frontend.layouts.app')

@section('title', $category->meta_title ?: $category->name . ' - Portal Berita')
@section('meta_description', $category->meta_description ?: 'Berita terbaru seputar ' . $category->name)
@section('meta_keywords', $category->meta_keywords)

@section('content')
{{-- Category Header --}}
<section class="py-4 border-bottom">
    <div class="container">
        <div class="text-center">
            <h1 class="fw-bold mb-2">{{ $category->name }}</h1>
            @if($category->description)
            <p class="lead text-muted mb-0">{{ $category->description }}</p>
            @endif
        </div>
    </div>
</section>

{{-- Articles Grid --}}
<section class="py-5">
    <div class="container">
        @if($articles->count() > 0)
        <div class="row g-4">
            @foreach($articles as $article)
            <div class="col-md-4">
                <div class="card card-article h-100">
                    <img src="{{ $article->cover_image_url ?? 'https://via.placeholder.com/400x250' }}" 
                         class="card-img-top" 
                         style="height: 200px; object-fit: cover;" 
                         alt="{{ $article->title }}">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">
                            <a href="{{ route('article.show', $article->slug) }}" class="text-decoration-none text-dark">
                                {{ $article->title }}
                            </a>
                        </h5>
                        <p class="card-text text-muted">{{ Str::limit($article->excerpt, 120) }}</p>
                        <div class="article-meta">
                            <span class="me-3"><i class="bi bi-person"></i> {{ $article->author->name }}</span>
                            <span class="me-3"><i class="bi bi-clock"></i> {{ $article->published_at->diffForHumans() }}</span>
                            <span><i class="bi bi-eye"></i> {{ number_format($article->views) }}</span>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('article.show', $article->slug) }}" class="btn btn-outline-warning btn-sm w-100">
                            Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-5 d-flex justify-content-center">
            {{ $articles->links('pagination::bootstrap-5') }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
            <h3 class="mt-3 text-muted">Belum Ada Artikel</h3>
            <p class="text-muted">Kategori ini belum memiliki artikel yang dipublikasikan.</p>
            <a href="{{ route('home') }}" class="btn btn-warning">
                <i class="bi bi-house"></i> Kembali ke Beranda
            </a>
        </div>
        @endif
    </div>
</section>

{{-- Related Categories --}}
@php
$otherCategories = \App\Models\Category::where('is_active', true)
    ->where('id', '!=', $category->id)
    ->orderBy('name')
    ->limit(6)
    ->get();
@endphp

@if($otherCategories->count() > 0)
<section class="bg-light py-5">
    <div class="container">
        <h3 class="section-title text-center">Kategori Lainnya</h3>
        <div class="row g-3">
            @foreach($otherCategories as $cat)
            <div class="col-md-2 col-6">
                <a href="{{ route('category.show', $cat->slug) }}" class="text-decoration-none">
                    <div class="card card-article text-center h-100">
                        <div class="card-body">
                            <i class="bi bi-folder2-open" style="font-size: 2rem; color: #ff9800;"></i>
                            <h6 class="mt-2 mb-1 fw-bold text-dark">{{ $cat->name }}</h6>
                            <small class="text-muted">{{ $cat->articles()->published()->count() }} artikel</small>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
