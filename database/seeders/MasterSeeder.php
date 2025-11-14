<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MasterSeeder extends Seeder
{
    /**
     * Master Seeder - Run all seeders in sequence with detailed logging
     * 
     * Usage:
     * php artisan db:seed --class=MasterSeeder
     * 
     * Or with fresh migration:
     * php artisan migrate:fresh --seed --seeder=MasterSeeder
     */
    public function run(): void
    {
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('🚀 PORTAL BERITA - MASTER SEEDER');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->newLine();

        // Check if tables exist
        $this->checkRequiredTables();

        // Array of seeders with metadata
        $seeders = [
            [
                'class' => RolePermissionSeeder::class,
                'name' => 'Role & Permission Seeder',
                'description' => 'Creating roles (Admin, Redaktur, Reporter) and permissions',
                'required' => true,
            ],
            [
                'class' => AdminSeeder::class,
                'name' => 'Admin User Seeder',
                'description' => 'Creating default admin user (admin@admin.com)',
                'required' => true,
            ],
            [
                'class' => PortalBeritaSeeder::class,
                'name' => 'Portal Berita Core Seeder',
                'description' => 'Seeding categories, tags, articles, pages, and users',
                'required' => true,
            ],
            [
                'class' => DefaultSettingsSeeder::class,
                'name' => 'Settings Seeder',
                'description' => 'Setting up default application settings',
                'required' => false,
            ],
            [
                'class' => TagSeeder::class,
                'name' => 'Additional Tags Seeder',
                'description' => 'Adding more tags for article categorization',
                'required' => false,
            ],
            [
                'class' => DummyArticleSeeder::class,
                'name' => 'Dummy Articles Seeder',
                'description' => 'Creating sample articles for testing',
                'required' => false,
            ],
        ];

        $totalSeeders = count($seeders);
        $completedSeeders = 0;
        $failedSeeders = 0;
        $skippedSeeders = 0;
        $totalTime = 0;

        $this->command->info("📊 Total Seeders to Run: {$totalSeeders}");
        $this->command->newLine();

        foreach ($seeders as $index => $seeder) {
            $currentNumber = $index + 1;
            
            $this->command->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            $this->command->info("📦 [{$currentNumber}/{$totalSeeders}] {$seeder['name']}");
            $this->command->line("   📝 {$seeder['description']}");
            $this->command->line("   ⚙️  Status: " . ($seeder['required'] ? 'Required' : 'Optional'));
            $this->command->newLine();

            try {
                $startTime = microtime(true);
                
                // Run the seeder
                $this->call($seeder['class']);
                
                $endTime = microtime(true);
                $executionTime = round($endTime - $startTime, 3);
                $totalTime += $executionTime;
                
                $this->command->info("   ✅ SUCCESS - Completed in {$executionTime}s");
                $completedSeeders++;
                
            } catch (\Exception $e) {
                $this->command->error("   ❌ FAILED - Error: " . $e->getMessage());
                $this->command->error("   📍 File: " . $e->getFile() . ":" . $e->getLine());
                
                if ($seeder['required']) {
                    $this->command->newLine();
                    $this->command->error('🛑 Required seeder failed! Stopping execution.');
                    $this->command->error('Please fix the error and try again.');
                    return;
                } else {
                    $this->command->warn("   ⚠️  Skipping optional seeder...");
                    $skippedSeeders++;
                }
                
                $failedSeeders++;
            }
            
            $this->command->newLine();
        }

        // Final Summary
        $this->displaySummary($totalSeeders, $completedSeeders, $failedSeeders, $skippedSeeders, $totalTime);
    }

    /**
     * Check if required tables exist
     */
    protected function checkRequiredTables(): void
    {
        $requiredTables = ['users', 'roles', 'permissions', 'categories', 'tags', 'articles'];
        $missingTables = [];

        foreach ($requiredTables as $table) {
            if (!Schema::hasTable($table)) {
                $missingTables[] = $table;
            }
        }

        if (!empty($missingTables)) {
            $this->command->error('❌ Missing required tables: ' . implode(', ', $missingTables));
            $this->command->warn('🔧 Please run migrations first: php artisan migrate');
            $this->command->newLine();
            exit(1);
        }

        $this->command->info('✅ All required tables exist');
        $this->command->newLine();
    }

    /**
     * Display final summary
     */
    protected function displaySummary($total, $completed, $failed, $skipped, $totalTime): void
    {
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('📊 SEEDING SUMMARY');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->newLine();
        
        $this->command->line("   📦 Total Seeders:     {$total}");
        $this->command->line("   ✅ Completed:         {$completed}");
        
        if ($failed > 0) {
            $this->command->line("   ❌ Failed:            {$failed}");
        }
        
        if ($skipped > 0) {
            $this->command->line("   ⚠️  Skipped:           {$skipped}");
        }
        
        $this->command->line("   ⏱️  Total Time:        " . round($totalTime, 2) . "s");
        
        $this->command->newLine();
        
        if ($failed === 0) {
            $this->command->info('🎉 ALL SEEDERS COMPLETED SUCCESSFULLY!');
        } else {
            $this->command->warn('⚠️  Some seeders failed. Please check the logs above.');
        }
        
        $this->command->newLine();
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('📋 NEXT STEPS:');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->newLine();
        $this->command->line('   1. Start the server:');
        $this->command->line('      php artisan serve');
        $this->command->newLine();
        $this->command->line('   2. Access admin panel:');
        $this->command->line('      http://localhost:8000/admin');
        $this->command->newLine();
        $this->command->line('   3. Login credentials:');
        $this->command->line('      Email: admin@admin.com');
        $this->command->line('      Password: password');
        $this->command->newLine();
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->newLine();
    }
}
