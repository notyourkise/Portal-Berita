<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DefaultSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set default headline article (latest published article)
        $latestArticle = Article::where('status', 'published')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->first();

        if ($latestArticle) {
            Setting::set('headline_article_id', $latestArticle->id, 'integer');
            $this->command->info("✓ Default headline set to: {$latestArticle->title}");
        }

        // Set default hot topics (top 5 tags by article count)
        $hotTopics = Tag::withCount(['articles' => function($q) {
                $q->where('status', 'published')
                  ->where('published_at', '<=', now());
            }])
            ->get()
            ->filter(function($tag) {
                return $tag->articles_count > 0;
            })
            ->sortByDesc('articles_count')
            ->take(5)
            ->pluck('id')
            ->toArray();

        if (!empty($hotTopics)) {
            Setting::set('hot_topics', $hotTopics, 'json');
            
            $tagNames = Tag::whereIn('id', $hotTopics)->pluck('name')->toArray();
            $this->command->info("✓ Default hot topics set to: " . implode(', ', $tagNames));
        }

        $this->command->info('Default settings created successfully!');
    }
}
