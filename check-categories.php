<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Category;

echo "=== KATEGORI YANG ADA DI DATABASE ===\n\n";

$categories = Category::orderBy('name')->get(['name', 'slug']);

foreach ($categories as $category) {
    echo "Name: {$category->name}\n";
    echo "Slug: {$category->slug}\n";
    echo "---\n";
}
