<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * This will run all seeders in sequence.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting Database Seeding...');
        $this->command->newLine();

        // Array of seeders to run in order
        $seeders = [
            ['class' => RolePermissionSeeder::class, 'description' => 'Setting up Roles & Permissions'],
            ['class' => AdminSeeder::class, 'description' => 'Creating Admin User'],
            ['class' => PortalBeritaSeeder::class, 'description' => 'Seeding Categories, Tags, Articles & Pages'],
            ['class' => DefaultSettingsSeeder::class, 'description' => 'Setting up Default Settings'],
            ['class' => TagSeeder::class, 'description' => 'Adding Additional Tags'],
            ['class' => DummyArticleSeeder::class, 'description' => 'Creating Dummy Articles for Testing'],
        ];

        $totalSeeders = count($seeders);
        $currentSeeder = 0;

        foreach ($seeders as $seeder) {
            $currentSeeder++;
            
            $this->command->info("📦 [{$currentSeeder}/{$totalSeeders}] {$seeder['description']}...");
            
            try {
                $startTime = microtime(true);
                
                $this->call($seeder['class']);
                
                $endTime = microtime(true);
                $executionTime = round($endTime - $startTime, 2);
                
                $this->command->info("   ✅ Completed in {$executionTime}s");
                $this->command->newLine();
                
            } catch (\Exception $e) {
                $this->command->error("   ❌ Failed: " . $e->getMessage());
                $this->command->newLine();
                
                // Optional: Stop on error or continue
                // throw $e; // Uncomment to stop on first error
            }
        }

        $this->command->newLine();
        $this->command->info('🎉 Database Seeding Completed Successfully!');
        $this->command->newLine();
        $this->command->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('📋 Summary:');
        $this->command->line('   • Roles & Permissions: ✅');
        $this->command->line('   • Admin User: ✅');
        $this->command->line('   • Categories & Tags: ✅');
        $this->command->line('   • Articles & Pages: ✅');
        $this->command->line('   • Settings: ✅');
        $this->command->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->newLine();
    }
}
