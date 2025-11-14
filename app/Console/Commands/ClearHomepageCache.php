<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearHomepageCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear-homepage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear homepage cache (run this after publishing new articles)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Cache::forget('homepage_data');
        Cache::forget('popular_articles');
        
        $this->info('✓ Homepage cache cleared successfully!');
        $this->info('  - homepage_data: cleared');
        $this->info('  - popular_articles: cleared');
        
        return Command::SUCCESS;
    }
}
