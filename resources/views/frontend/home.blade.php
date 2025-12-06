@extends('frontend.layouts.app')

@section('title', 'Portal Berita - Berita Terkini Indonesia')

@section('content')
{{-- Latest News --}}
<section class="py-4 py-md-5">
    <div class="container">
        <h2 class="section-title">Informasi Terbaru</h2>
        <div class="row g-3 g-md-4">
            {{-- Main Content (8 columns on desktop) --}}
            <div class="col-lg-8">
                <div class="row g-3">
                    @if($latestArticles->count() > 0)
                        @php
                            $headline = $latestArticles->first();
                        @endphp
                        
                        {{-- Headline Besar --}}
                        <div class="col-12 col-md-6">
                            <div class="card card-article border-0 shadow-sm">
                                <div class="position-relative headline-image">
                                    {!! article_cover($headline, 'large', 'card-img-top w-100') !!}
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge px-3 py-2" style="background-color: #fcdd01; color: #214594; font-weight: 700;">
                                            <i class="bi bi-star-fill"></i> Headline
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body p-2">
                                    <span class="category-badge">{{ $headline->category->name }}</span>
                                    <h5 class="card-title mt-2 fw-bold mb-2">
                                        <a href="{{ route('article.show', $headline->slug) }}" class="text-decoration-none text-dark">
                                            {{ $headline->title }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted mb-2" style="font-size: 0.85rem;">{{ Str::limit($headline->excerpt, 150) }}</p>
                                    <div class="article-meta small">
                                        <span class="me-3"><i class="bi bi-clock"></i> {{ $headline->published_at->diffForHumans() }}</span>
                                        <span class="me-3"><i class="bi bi-book text-primary"></i> {{ $headline->reading_time }} mnt</span>
                                        <span><i class="bi bi-eye"></i> {{ number_format($headline->views) }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- 2 Card Kecil di Bawah Headline --}}
                            <div class="row g-2 mt-2 justify-content-center">
                                @foreach($latestArticles->skip(1)->take(2) as $article)
                                <div class="col-5">
                                    <div class="card card-article border-0 shadow-sm h-100">
                                        <div class="position-relative small-bottom-card-image">
                                            {!! article_cover($article, 'small', 'card-img-top w-100') !!}
                                        </div>
                                        <div class="card-body p-1">
                                            <h6 class="card-title mt-1 fw-bold mb-1 small-bottom-card-title">
                                                <a href="{{ route('article.show', $article->slug) }}" class="text-decoration-none text-dark">
                                                    {{ Str::limit($article->title, 40) }}
                                                </a>
                                            </h6>
                                            <div class="article-meta-tiny">
                                                <span><i class="bi bi-clock"></i> {{ $article->published_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Card Kecil di Samping Kanan Headline --}}
                        <div class="col-12 col-md-6">
                            <div class="row g-2">
                                @foreach($latestArticles->skip(3)->take(9) as $article)
                                <div class="col-4">
                                    <div class="card card-article border-0 shadow-sm h-100">
                                        <div class="position-relative small-bottom-card-image">
                                            {!! article_cover($article, 'small', 'card-img-top w-100') !!}
                                        </div>
                                        <div class="card-body p-1">
                                            <h6 class="card-title mt-1 fw-bold mb-1 small-bottom-card-title">
                                                <a href="{{ route('article.show', $article->slug) }}" class="text-decoration-none text-dark">
                                                    {{ Str::limit($article->title, 40) }}
                                                </a>
                                            </h6>
                                            <div class="article-meta-tiny">
                                                <span><i class="bi bi-clock"></i> {{ $article->published_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="col-12">
                            <p class="text-center text-muted">Belum ada artikel terbaru.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar: Hot Topics (4 columns) --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top hot-topics-card">
                    <div class="card-header text-white border-0 py-2" style="background-color: #214594;">
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-fire"></i> Hot Topics
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach($hotTopics as $topic)
                            <a href="{{ route('tag.show', $topic->slug) }}" class="list-group-item list-group-item-action d-flex align-items-center py-2">
                                <span class="badge rounded-circle me-2 hot-topic-number" style="background-color: #fcdd01; color: #214594;">
                                    {{ $loop->iteration }}
                                </span>
                                <div class="flex-grow-1">
                                    <div class="fw-bold hot-topic-name">
                                        {{ $topic->name }}
                                        @if($loop->first)
                                        <span style="font-size: 1rem;">🔥</span>
                                        @endif
                                    </div>
                                    <small class="text-muted hot-topic-count">{{ $topic->articles_count }} artikel</small>
                                </div>
                                <i class="bi bi-chevron-right text-muted small"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Categories Sections --}}
@foreach($categories as $category)
@if(isset($categorizedArticles[$category->slug]) && $categorizedArticles[$category->slug]->count() > 0)
<section class="py-4 py-md-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
            <h2 class="section-title mb-0">{{ $category->name }}</h2>
            <a href="{{ route('category.show', $category->slug) }}" class="btn btn-sm" style="background-color: #fcdd01; color: #214594; border-color: #fcdd01;">
                Lihat Semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="row g-3 g-md-4">
            @foreach($categorizedArticles[$category->slug] as $article)
            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                <div class="card card-article h-100">
                    <div class="category-card-image">
                        {!! article_cover($article, 'medium', 'card-img-top w-100') !!}
                    </div>
                    <div class="card-body p-2 p-md-3">
                        <h6 class="card-title fw-bold category-card-title">
                            <a href="{{ route('article.show', $article->slug) }}" class="text-decoration-none text-dark">
                                {{ Str::limit($article->title, 60) }}
                            </a>
                        </h6>
                        <div class="article-meta small">
                            <span><i class="bi bi-clock"></i> {{ $article->published_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endforeach

{{-- Mahasiswa Section --}}
@if($mahasiswaArticles->count() > 0)
<section class="py-4 py-md-5 section-mahasiswa" id="section-mahasiswa">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
            <h2 class="section-title mb-0">
                Kegiatan Mahasiswa
            </h2>
            <a href="{{ route('mahasiswa') }}" class="btn btn-sm" style="background-color: #fcdd01; color: #214594; border-color: #fcdd01;">
                Lihat Semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="row g-3 g-md-4">
            @foreach($mahasiswaArticles as $article)
            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                <div class="card card-article h-100">
                    <div class="category-card-image">
                        {!! article_cover($article, 'medium', 'card-img-top w-100') !!}
                    </div>
                    <div class="card-body p-2 p-md-3">
                        <h6 class="card-title fw-bold category-card-title">
                            <a href="{{ route('article.show', $article->slug) }}" class="text-decoration-none text-dark">
                                {{ Str::limit($article->title, 60) }}
                            </a>
                        </h6>
                        <div class="article-meta small">
                            <span><i class="bi bi-clock"></i> {{ $article->published_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Popular / Trending --}}
@if($popularArticles->count() > 0)
<section class="py-4 py-md-5">
    <div class="container">
        <h2 class="section-title">Trending</h2>
        <div class="row">
            @foreach($popularArticles as $index => $article)
            <div class="col-12 mb-2 mb-md-3">
                <div class="trending-item d-flex align-items-start">
                    <div class="trending-number me-2 me-md-3">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-1 trending-title">
                            <a href="{{ route('article.show', $article->slug) }}" class="text-decoration-none text-dark">
                                {{ $article->title }}
                            </a>
                        </h5>
                        <div class="article-meta small">
                            <span class="me-2 me-md-3"><i class="bi bi-folder"></i> {{ $article->category->name }}</span>
                            <span class="me-2 me-md-3 d-none d-sm-inline"><i class="bi bi-eye"></i> {{ number_format($article->views) }} views</span>
                            <span><i class="bi bi-clock"></i> {{ $article->published_at->diffForHumans() }}</span>
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

@push('styles')
<style>
    /* Responsive Styles for Home Page */
    
    /* Headline Image - Card Besar */
    .headline-image {
        height: 350px;
        overflow: hidden;
    }
    
    .headline-image img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }

    /* Small Bottom Cards - 2 Card Kecil di Bawah Headline */
    .small-bottom-card-image {
        height: 120px;
        overflow: hidden;
    }

    .small-bottom-card-image img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }

    .small-bottom-card-title {
        font-size: 0.75rem;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .article-meta-tiny {
        font-size: 0.65rem;
        color: #6c757d;
        margin-top: 2px;
    }

    .article-meta-tiny i {
        font-size: 0.55rem;
    }

    /* Small Cards - 7 Card Kecil (4 samping, 3 bawah) */
    .small-card {
        height: 100px;
        overflow: hidden;
    }

    .small-img {
        object-fit: cover;
        height: 100px;
    }

    .small-title {
        font-size: 0.8rem;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .category-badge-small {
        background-color: #214594;
        color: white;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 0.65rem;
        font-weight: 600;
        display: inline-block;
    }

    .article-meta-small {
        font-size: 0.7rem;
        color: #6c757d;
        margin-top: 4px;
    }

    .article-meta-small i {
        font-size: 0.65rem;
    }

    /* Category Cards */
    .category-card-image {
        height: 140px;
        overflow: hidden;
    }

    .category-card-image img {
        object-fit: cover;
        height: 100%;
    }

    .category-card-title {
        font-size: 0.9rem;
        line-height: 1.4;
    }

    /* Hot Topics */
    .hot-topics-card {
        top: 20px;
    }

    .hot-topic-number {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: bold;
    }

    .hot-topic-name {
        font-size: 0.9rem;
    }

    .hot-topic-count {
        font-size: 0.75rem;
    }

    /* Trending Title */
    .trending-title {
        font-size: 1.1rem;
    }

    /* Mobile (up to 575px) */
    @media (max-width: 575.98px) {
        .headline-image {
            height: 200px;
        }

        .small-card {
            height: 90px;
        }

        .small-img {
            height: 90px;
        }

        .small-title {
            font-size: 0.75rem;
        }

        .category-badge-small {
            font-size: 0.6rem;
            padding: 2px 6px;
        }

        .article-meta-small {
            font-size: 0.65rem;
        }

        .category-card-image {
            height: 120px;
        }

        .category-card-title {
            font-size: 0.8rem;
        }

        .hot-topics-card {
            position: static !important;
            margin-top: 1rem;
        }

        .hot-topic-number {
            width: 24px;
            height: 24px;
            font-size: 11px;
        }

        .hot-topic-name {
            font-size: 0.85rem;
        }

        .trending-title {
            font-size: 1rem;
        }
    }

    /* Tablets (576px - 767px) */
    @media (min-width: 576px) and (max-width: 767.98px) {
        .headline-image {
            height: 250px;
        }

        .small-card {
            height: 95px;
        }

        .small-img {
            height: 95px;
        }

        .hot-topics-card {
            position: static !important;
            margin-top: 1.5rem;
        }
    }

    /* Tablets landscape (768px - 991px) */
    @media (min-width: 768px) and (max-width: 991.98px) {
        .headline-image {
            height: 150px;
        }

        .small-card {
            height: 100px;
        }

        .small-img {
            height: 100px;
        }

        .category-card-image {
            height: 150px;
        }

        .hot-topics-card {
            position: static !important;
            margin-top: 1.5rem;
        }
    }

    /* Desktops (992px - 1199px) */
    @media (min-width: 992px) and (max-width: 1199.98px) {
        .headline-image {
            height: 220px;
        }

        .small-card {
            height: 105px;
        }

        .small-img {
            height: 105px;
        }

        .small-title {
            font-size: 0.78rem;
        }
    }

    /* Large Desktops (1200px+) */
    @media (min-width: 1200px) {
        .headline-image {
            height: 240px;
        }

        .small-card {
            height: 110px;
        }

        .small-img {
            height: 110px;
        }

        .small-title {
            font-size: 0.82rem;
        }

        .category-card-image {
            height: 160px;
        }

        .trending-title {
            font-size: 1.2rem;
        }
    }

    /* Card hover effects */
    .card-article {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-article:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(33, 69, 148, 0.15) !important;
    }

    .card-article a:hover {
        color: #214594 !important;
    }

    /* Section Mahasiswa - Light Mode */
    .section-mahasiswa {
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }

    /* Section Mahasiswa - Dark Mode */
    body.dark-mode .section-mahasiswa {
        background-color: #1a1a1a;
    }
</style>
@endpush
