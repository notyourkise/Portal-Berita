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

            {{-- Page Content --}}
            <div class="page-content bg-white p-4 rounded shadow-sm">
                <div class="content-text" style="line-height: 1.8; font-size: 1.05rem;">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
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
