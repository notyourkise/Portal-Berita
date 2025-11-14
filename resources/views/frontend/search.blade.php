@extends('frontend.layouts.app')

@section('title', 'Pencarian: ' . ($keyword ?: 'Semua Artikel') . ' - Portal Berita')

@section('content')
{{-- Search Results --}}
<section class="py-5">
    <div class="container">
        @if($keyword)
        <div class="mb-4">
            <h2 class="fw-bold">
                <i class="bi bi-search"></i> Hasil Pencarian
            </h2>
            <p class="text-muted">
                Kata kunci: <strong>"{{ $keyword }}"</strong>
                <span class="badge bg-warning text-dark ms-2">{{ $articles->total() }} artikel ditemukan</span>
            </p>
        </div>
        @endif

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
                        <span class="category-badge mb-2">{{ $article->category->name }}</span>
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
            {{ $articles->appends(['q' => $keyword])->links('pagination::bootstrap-5') }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-search" style="font-size: 4rem; color: #ccc;"></i>
            <h3 class="mt-3 text-muted">Tidak Ada Hasil</h3>
            @if($keyword)
            <p class="text-muted">Tidak ditemukan artikel dengan kata kunci "{{ $keyword }}"</p>
            <p class="text-muted">Coba gunakan kata kunci yang berbeda atau lebih umum.</p>
            @else
            <p class="text-muted">Masukkan kata kunci untuk mencari artikel.</p>
            @endif
            <a href="{{ route('home') }}" class="btn btn-warning mt-3">
                <i class="bi bi-house"></i> Kembali ke Beranda
            </a>
        </div>
        @endif
    </div>
</section>

{{-- Search Tips --}}
@if($articles->count() == 0 && $keyword)
<section class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-bold"><i class="bi bi-lightbulb"></i> Tips Pencarian</h5>
                        <ul class="mb-0">
                            <li>Gunakan kata kunci yang lebih umum</li>
                            <li>Periksa ejaan kata kunci</li>
                            <li>Coba gunakan sinonim atau kata yang berbeda</li>
                            <li>Gunakan kata kunci yang lebih pendek</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Popular Articles --}}
@if($articles->count() == 0)
<section class="py-5">
    <div class="container">
        <h3 class="section-title text-center">Artikel Populer</h3>
        <div class="row g-4">
            @foreach(\App\Models\Article::published()->orderBy('views', 'desc')->limit(6)->get() as $popular)
            <div class="col-md-4">
                <div class="card card-article h-100">
                    <img src="{{ $popular->cover_image_url ?? 'https://via.placeholder.com/400x200' }}" 
                         class="card-img-top" 
                         alt="{{ $popular->title }}">
                    <div class="card-body">
                        <span class="category-badge">{{ $popular->category->name }}</span>
                        <h5 class="card-title mt-2 fw-bold">
                            <a href="{{ route('article.show', $popular->slug) }}" class="text-decoration-none text-dark">
                                {{ Str::limit($popular->title, 60) }}
                            </a>
                        </h5>
                        <div class="article-meta">
                            <span><i class="bi bi-eye"></i> {{ number_format($popular->views) }} views</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
