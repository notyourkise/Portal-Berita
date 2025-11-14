<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Article;

echo "=== CEK SEMUA ARTIKEL ===\n\n";

$articles = Article::with(['category', 'tags'])->get();

foreach ($articles as $article) {
    echo "ID: {$article->id}\n";
    echo "Title: {$article->title}\n";
    echo "Status: {$article->status}\n";
    echo "Category: " . ($article->category ? $article->category->name : 'N/A') . "\n";
    echo "Tags: " . ($article->tags->count() > 0 ? $article->tags->pluck('name')->implode(', ') : 'Tidak ada tag') . "\n";
    echo "Published At: " . ($article->published_at ? $article->published_at->format('Y-m-d H:i:s') : 'Belum diset') . "\n";
    echo "Published?: " . ($article->status === 'published' && $article->published_at && $article->published_at <= now() ? 'YA' : 'TIDAK') . "\n";
    echo "---\n\n";
}

echo "\n=== RINGKASAN ===\n";
echo "Total artikel: " . Article::count() . "\n";
echo "Status Published: " . Article::where('status', 'published')->count() . "\n";
echo "Published + waktu valid: " . Article::where('status', 'published')->where('published_at', '<=', now())->count() . "\n";
echo "Artikel dengan tag: " . Article::has('tags')->count() . "\n";
echo "Artikel dengan tag Sepakbola: " . Article::whereHas('tags', function($q) { $q->where('slug', 'sepakbola'); })->count() . "\n";
