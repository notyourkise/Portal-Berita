@extends('frontend.layouts.app')

@section('title', 'Portal Berita - Berita Terkini Indonesia')

@section('content')
{{-- Latest News --}}
<section class="py-4 py-md-5">
    <div class="container">
        <h2 class="section-title">Berita Terbaru</h2>
        <div class="row g-3 g-md-4">
            {{-- Main Content (8 columns on desktop) --}}
            <div class="col-lg-8">
                <div class="row g-3">
                    @if($latestArticles->count() > 0)
                        {{-- ROW 1: Headline (kiri) + 3 Card (kanan) --}}
                        @php
                            $headline = $latestArticles->first();
                        @endphp
                        
                        {{-- Headline Besar --}}
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card card-article border-0 shadow-sm h-100">
                                <div class="position-relative headline-image">
                                    {!! article_cover($headline, 'large', 'card-img-top w-100') !!}
                                    <div class="position-absolute top-0 start-0 m-2 m-md-3">
                                        <span class="badge bg-danger px-2 py-1 px-md-3 py-md-2">
                                            <i class="bi bi-star-fill"></i> Headline
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body p-2 p-md-3">
                                    <span class="category-badge">{{ $headline->category->name }}</span>
                                    <h4 class="card-title mt-2 fw-bold mb-2">
                                        <a href="{{ route('article.show', $headline->slug) }}" class="text-decoration-none text-dark">
                                            {{ Str::limit($headline->title, 80) }}
                                        </a>
                                    </h4>
                                    <p class="card-text text-muted small mb-2 d-none d-md-block">{{ Str::limit($headline->excerpt, 100) }}</p>
                                    <div class="article-meta small">
                                        <span class="me-2"><i class="bi bi-clock"></i> {{ $headline->published_at->diffForHumans() }}</span>
                                        <span class="me-2 d-none d-sm-inline"><i class="bi bi-book text-primary"></i> {{ $headline->reading_time }} mnt</span>
                                        <span class="d-none d-sm-inline"><i class="bi bi-eye"></i> {{ number_format($headline->views) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 3 Card Kanan (Ukuran Sama) --}}
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="row g-2 g-md-3">
                                @foreach($latestArticles->skip(1)->take(3) as $article)
                                <div class="col-12">
                                    <div class="card card-article border-0 shadow-sm compact-card">
                                        <div class="row g-0 h-100">
                                            <div class="col-4 col-sm-4">
                                                {!! article_cover($article, 'small', 'w-100 h-100 compact-img') !!}
                                            </div>
                                            <div class="col-8 col-sm-8">
                                                <div class="card-body p-2 d-flex flex-column h-100">
                                                    <span class="category-badge small">{{ $article->category->name }}</span>
                                                    <h6 class="card-title mt-1 fw-bold mb-1 compact-title">
                                                        <a href="{{ route('article.show', $article->slug) }}" class="text-decoration-none text-dark">
                                                            {{ Str::limit($article->title, 60) }}
                                                        </a>
                                                    </h6>
                                                    <div class="article-meta small mt-auto">
                                                        <span><i class="bi bi-clock"></i> {{ $article->published_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- ROW 2: 3 Card Bawah (Ukuran Sama Semua) --}}
                        @foreach($latestArticles->skip(4)->take(3) as $article)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="card card-article border-0 shadow-sm compact-card">
                                <div class="row g-0 h-100">
                                    <div class="col-5 col-sm-5">
                                        {!! article_cover($article, 'small', 'w-100 h-100 compact-img') !!}
                                    </div>
                                    <div class="col-7 col-sm-7">
                                        <div class="card-body p-2 d-flex flex-column h-100">
                                            <span class="category-badge small">{{ $article->category->name }}</span>
                                            <h6 class="card-title mt-1 fw-bold mb-1 compact-title">
                                                <a href="{{ route('article.show', $article->slug) }}" class="text-decoration-none text-dark">
                                                    {{ Str::limit($article->title, 50) }}
                                                </a>
                                            </h6>
                                            <div class="article-meta small mt-auto">
                                                <span><i class="bi bi-clock"></i> {{ $article->published_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
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
                    <div class="card-header bg-danger text-white border-0 py-2">
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-fire"></i> Hot Topics
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach($hotTopics as $topic)
                            <a href="{{ route('tag.show', $topic->slug) }}" class="list-group-item list-group-item-action d-flex align-items-center py-2">
                                <span class="badge bg-danger rounded-circle me-2 hot-topic-number">
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
            <a href="{{ route('category.show', $category->slug) }}" class="btn btn-outline-warning btn-sm">
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
    
    /* Headline Image */
    .headline-image {
        height: 200px;
        overflow: hidden;
    }
    
    .headline-image img {
        object-fit: cover;
        height: 100%;
    }

    /* Compact Cards */
    .compact-card {
        height: 110px;
    }

    .compact-img {
        object-fit: cover;
    }

    .compact-title {
        font-size: 0.85rem;
        line-height: 1.3;
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
            height: 180px;
        }

        .compact-card {
            height: 100px;
        }

        .compact-title {
            font-size: 0.8rem;
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

    /* Tablets (576px - 991px) */
    @media (min-width: 576px) and (max-width: 991.98px) {
        .headline-image {
            height: 220px;
        }

        .compact-card {
            height: 120px;
        }

        .category-card-image {
            height: 150px;
        }

        .hot-topics-card {
            position: static !important;
            margin-top: 1.5rem;
        }
    }

    /* Desktops (992px+) */
    @media (min-width: 992px) {
        .headline-image {
            height: 230px;
        }

        .compact-card {
            height: 120px;
        }

        .category-card-image {
            height: 150px;
        }
    }

    /* Large Desktops (1200px+) */
    @media (min-width: 1200px) {
        .headline-image {
            height: 250px;
        }

        .category-card-image {
            height: 160px;
        }

        .trending-title {
            font-size: 1.2rem;
        }
    }
</style>
@endpush
