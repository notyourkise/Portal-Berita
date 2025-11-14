<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Article;

// Ambil artikel terakhir yang published
$article = Article::where('status', 'published')->latest('id')->first();

if (!$article) {
    echo "Tidak ada artikel published\n";
    exit;
}

echo "=== DEBUG PAGINATION ===\n\n";
echo "Artikel: {$article->title}\n";
echo "ID: {$article->id}\n\n";

$bodyHtml = $article->body;
$bodyText = strip_tags($bodyHtml);

echo "Body HTML length: " . mb_strlen($bodyHtml) . " characters\n";
echo "Body TEXT length: " . mb_strlen($bodyText) . " characters\n\n";

echo "Body HTML (first 500 chars):\n";
echo substr($bodyHtml, 0, 500) . "...\n\n";

echo "Body TEXT (first 500 chars):\n";
echo substr($bodyText, 0, 500) . "...\n\n";

// Test split
$charsPerPage = 1000;
$totalPages = (int) ceil(mb_strlen($bodyText) / $charsPerPage);
echo "Expected pages (3000 chars / 1000): $totalPages pages\n";
