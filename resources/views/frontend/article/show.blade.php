@extends('frontend.layouts.app')

@section('title', $article->meta_title ?: $article->title . ' - Portal Berita')
@section('meta_description', $article->meta_description ?: Str::limit(strip_tags($article->body), 160))
@section('meta_keywords', $article->meta_keywords)

@section('og_title', $article->title)
@section('og_description', $article->excerpt)
@section('og_image', $article->cover_image_url ?? asset('images/default-og.jpg'))
@section('og_url', route('article.show', $article->slug))

@section('content')
{{-- Article Content --}}
<article class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                {{-- Article Header --}}
                <div class="mb-4">
                    <span class="category-badge mb-2 d-inline-block">{{ $article->category->name }}</span>
                    <h1 class="fw-bold mb-3">{{ $article->title }}</h1>
                    
                    <div class="article-meta mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center flex-wrap">
                            <div class="me-4 mb-2">
                                <i class="bi bi-person-circle text-warning me-1"></i>
                                <strong>{{ $article->author->name }}</strong>
                            </div>
                            <div class="me-4 mb-2">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $article->published_at->format('d M Y, H:i') }}
                            </div>
                            <div class="me-4 mb-2">
                                <i class="bi bi-book text-primary me-1"></i>
                                <strong>{{ $article->reading_time_text }}</strong> baca
                            </div>
                            <div class="mb-2">
                                <i class="bi bi-eye me-1"></i>
                                {{ number_format($article->views) }} views
                            </div>
                        </div>
                    </div>

                    {{-- Excerpt --}}
                    @if($article->excerpt)
                    <p class="lead text-muted fst-italic">{{ $article->excerpt }}</p>
                    @endif
                </div>

                {{-- Cover Image --}}
                @if($article->cover_image)
                <div class="mb-4">
                    <img src="{{ $article->cover_image_url }}" 
                         alt="{{ $article->title }}" 
                         class="img-fluid rounded w-100">
                </div>
                @endif

                {{-- Article Body --}}
                <div class="article-body mb-4">
                    {!! $currentContent !!}
                </div>

                {{-- Pagination --}}
                @if($totalPages > 1)
                <div class="mb-4">
                    <nav aria-label="Article pagination">
                        <ul class="pagination justify-content-center">
                            {{-- Previous Button --}}
                            @if($currentPage > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ route('article.show', $article->slug) }}?page={{ $currentPage - 1 }}">
                                    <i class="bi bi-chevron-left"></i> Halaman Sebelumnya
                                </a>
                            </li>
                            @else
                            <li class="page-item disabled">
                                <span class="page-link"><i class="bi bi-chevron-left"></i> Halaman Sebelumnya</span>
                            </li>
                            @endif

                            {{-- Page Numbers --}}
                            @for($i = 1; $i <= $totalPages; $i++)
                                @if($i == 1 || $i == $totalPages || abs($i - $currentPage) <= 2)
                                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                    <a class="page-link" href="{{ route('article.show', $article->slug) }}?page={{ $i }}">{{ $i }}</a>
                                </li>
                                @elseif(abs($i - $currentPage) == 3)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                                @endif
                            @endfor

                            {{-- Next Button --}}
                            @if($currentPage < $totalPages)
                            <li class="page-item">
                                <a class="page-link" href="{{ route('article.show', $article->slug) }}?page={{ $currentPage + 1 }}">
                                    Halaman Berikutnya <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                            @else
                            <li class="page-item disabled">
                                <span class="page-link">Halaman Berikutnya <i class="bi bi-chevron-right"></i></span>
                            </li>
                            @endif
                        </ul>
                    </nav>
                    
                    {{-- Page Info --}}
                    <div class="text-center text-muted small">
                        Halaman {{ $currentPage }} dari {{ $totalPages }}
                    </div>
                </div>
                @endif

                {{-- Tags --}}
                @if($article->tags->count() > 0)
                <div class="mb-4">
                    <h6 class="fw-bold mb-2"><i class="bi bi-tags"></i> Tags:</h6>
                    @foreach($article->tags as $tag)
                    <a href="{{ route('tag.show', $tag->slug) }}" class="badge bg-secondary text-decoration-none me-1 mb-1">{{ $tag->name }}</a>
                    @endforeach
                </div>
                @endif

                {{-- Share Buttons --}}
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-share"></i> Bagikan Artikel Ini:</h6>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('article.show', $article->slug)) }}" 
                               target="_blank" 
                               class="btn btn-primary btn-sm">
                                <i class="bi bi-facebook"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('article.show', $article->slug)) }}&text={{ urlencode($article->title) }}" 
                               target="_blank" 
                               class="btn btn-info btn-sm text-white">
                                <i class="bi bi-twitter"></i> Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . route('article.show', $article->slug)) }}" 
                               target="_blank" 
                               class="btn btn-success btn-sm">
                                <i class="bi bi-whatsapp"></i> WhatsApp
                            </a>
                            <button onclick="copyToClipboard()" class="btn btn-secondary btn-sm">
                                <i class="bi bi-link-45deg"></i> Copy Link
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Related Articles --}}
                @if($relatedArticles->count() > 0)
                <div class="mt-5">
                    <h3 class="section-title">Artikel Terkait</h3>
                    <div class="row g-3">
                        @foreach($relatedArticles as $related)
                        <div class="col-md-6">
                            <div class="card card-article h-100">
                                <div class="row g-0">
                                    <div class="col-4">
                                        <img src="{{ $related->cover_image_url ?? 'https://via.placeholder.com/150x100' }}" 
                                             class="img-fluid rounded-start h-100" 
                                             style="object-fit: cover;" 
                                             alt="{{ $related->title }}">
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body p-2">
                                            <h6 class="card-title fw-bold mb-1">
                                                <a href="{{ route('article.show', $related->slug) }}" class="text-decoration-none text-dark">
                                                    {{ Str::limit($related->title, 60) }}
                                                </a>
                                            </h6>
                                            <div class="article-meta small">
                                                <span><i class="bi bi-clock"></i> {{ $related->published_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                <div class="position-sticky" style="top: 100px;">
                    {{-- Popular Articles Widget --}}
                    <div class="card mb-4">
                        <div class="card-header bg-warning">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-fire"></i> Populer</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach(\App\Models\Article::published()->orderBy('views', 'desc')->limit(5)->get() as $popular)
                                <a href="{{ route('article.show', $popular->slug) }}" 
                                   class="list-group-item list-group-item-action">
                                    <h6 class="mb-1 fw-bold">{{ Str::limit($popular->title, 60) }}</h6>
                                    <small class="text-muted">
                                        <i class="bi bi-eye"></i> {{ number_format($popular->views) }} views
                                    </small>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Categories Widget --}}
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-folder"></i> Kategori</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach(\App\Models\Category::where('is_active', true)->orderBy('name')->get() as $cat)
                                <a href="{{ route('category.show', $cat->slug) }}" 
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    {{ $cat->name }}
                                    <span class="badge bg-warning rounded-pill">{{ $cat->articles()->published()->count() }}</span>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
@endsection

@push('scripts')
<script>
function copyToClipboard() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        alert('Link berhasil disalin!');
    }).catch(err => {
        console.error('Failed to copy: ', err);
    });
}
</script>
@endpush

@push('styles')
<style>
.article-body {
    font-size: 1.1rem;
    line-height: 1.8;
}

.article-body img {
    max-width: 100%;
    height: auto;
    margin: 20px 0;
    border-radius: 8px;
}

.article-body p {
    margin-bottom: 1.5rem;
}

.article-body h2, .article-body h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: bold;
}
</style>
@endpush
