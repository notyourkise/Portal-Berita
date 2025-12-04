<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\RssController;
use App\Http\Controllers\PageController;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/article/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/tag/{slug}', [TagController::class, 'show'])->name('tag.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Page Routes (for Visi Misi, About, etc)
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');

// Mahasiswa Routes (Kegiatan Mahasiswa category)
Route::get('/mahasiswa', [CategoryController::class, 'mahasiswa'])->name('mahasiswa');

// SEO Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/feed', [RssController::class, 'index'])->name('rss');
Route::get('/feed/category/{slug}', [RssController::class, 'category'])->name('rss.category');
