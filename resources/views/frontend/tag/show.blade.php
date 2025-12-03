@extends('frontend.layouts.app')

@section('title', $tag->meta_title ?: 'Tag: ' . $tag->name . ' - Portal Berita')
@section('meta_description', $tag->meta_description ?: 'Artikel dengan tag ' . $tag->name)
@section('meta_keywords', $tag->meta_keywords)

@section('content')
{{-- Tag Header --}}
<section class="py-4 border-bottom">
    <div class="container">
        <div class="text-center">
            <h1 class="fw-bold mb-2">{{ $tag->name }}</h1>
            @if($tag->description)
            <p class="lead text-muted mb-0">{{ $tag->description }}</p>
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
                    {!! article_cover($article, 'medium', 'card-img-top') !!}
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
                        <a href="{{ route('article.show', $article->slug) }}" class="btn btn-sm w-100" style="background-color: #fcdd01; color: #214594; border: 1px solid #fcdd01;">
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
            <i class="bi bi-tag" style="font-size: 4rem; color: #ccc;"></i>
            <h3 class="mt-3 text-muted">Belum Ada Artikel</h3>
            <p class="text-muted">Tag ini belum memiliki artikel yang dipublikasikan.</p>
            <a href="{{ route('home') }}" class="btn" style="background-color: #fcdd01; color: #214594;">
                <i class="bi bi-house"></i> Kembali ke Beranda
            </a>
        </div>
        @endif
    </div>
</section>

{{-- Popular Tags --}}
@php
$popularTags = \App\Models\Tag::withCount(['articles' => function($q) {
        $q->where('status', 'published')
          ->where('published_at', '<=', now());
    }])
    ->get()
    ->filter(function($tag) {
        return $tag->articles_count > 0;
    })
    ->sortByDesc('articles_count')
    ->take(20);
@endphp

@if($popularTags->count() > 0)
<section class="bg-light py-5">
    <div class="container">
        <h3 class="section-title text-center">Tag Populer</h3>
        <div class="d-flex flex-wrap justify-content-center gap-2">
            @foreach($popularTags as $popularTag)
            <a href="{{ route('tag.show', $popularTag->slug) }}" 
               class="badge {{ $popularTag->id == $tag->id ? 'text-decoration-none px-3 py-2' : 'bg-secondary text-decoration-none px-3 py-2' }}" 
               style="{{ $popularTag->id == $tag->id ? 'background-color: #fcdd01; color: #214594;' : '' }}">
                {{ $popularTag->name }}
                <span class="badge bg-dark ms-1">{{ $popularTag->articles_count }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
