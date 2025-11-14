<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🔐 Setting up Roles & Permissions...');

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ============================================
        // CREATE PERMISSIONS
        // ============================================
        
        $permissions = [
            // Article Permissions
            'view_articles',
            'view_own_articles',
            'create_articles',
            'edit_articles',
            'edit_own_articles',
            'delete_articles',
            'delete_own_articles',
            'publish_articles',
            'schedule_articles',
            'approve_articles',
            
            // Category Permissions
            'view_categories',
            'create_categories',
            'edit_categories',
            'delete_categories',
            
            // Tag Permissions
            'view_tags',
            'create_tags',
            'edit_tags',
            'delete_tags',
            
            // Page Permissions
            'view_pages',
            'create_pages',
            'edit_pages',
            'delete_pages',
            
            // User Management
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            
            // Settings
            'manage_settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $this->command->info('✅ Permissions created');

        // ============================================
        // CREATE ROLES & ASSIGN PERMISSIONS
        // ============================================

        // 👑 ADMIN - Full Access
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());
        $this->command->info('✅ Admin role created with all permissions');

        // 🧑‍🏫 REDAKTUR - Editorial Management
        $redaktur = Role::create(['name' => 'redaktur']);
        $redaktur->givePermissionTo([
            // Articles - can view all, edit all, publish, but not delete published
            'view_articles',
            'create_articles',
            'edit_articles',
            'delete_own_articles', // Can delete own drafts
            'publish_articles',
            'schedule_articles',
            'approve_articles',
            
            // Categories & Tags - create and edit
            'view_categories',
            'create_categories',
            'edit_categories',
            'view_tags',
            'create_tags',
            'edit_tags',
            
            // Pages - create and edit
            'view_pages',
            'create_pages',
            'edit_pages',
        ]);
        $this->command->info('✅ Redaktur role created');

        // 👩‍💻 REPORTER - Content Creation
        $reporter = Role::create(['name' => 'reporter']);
        $reporter->givePermissionTo([
            // Articles - own articles only
            'view_own_articles',
            'create_articles',
            'edit_own_articles',
            'delete_own_articles',
            
            // Categories & Tags - view only
            'view_categories',
            'view_tags',
        ]);
        $this->command->info('✅ Reporter role created');

        // ============================================
        // ASSIGN ROLES TO EXISTING USERS
        // ============================================

        $adminUser = User::where('email', 'admin@admin.com')->first();
        if ($adminUser) {
            $adminUser->assignRole('admin');
            $this->command->info('✅ Admin role assigned to admin@admin.com');
        }

        $redakturUser = User::where('email', 'redaktur@admin.com')->first();
        if ($redakturUser) {
            $redakturUser->assignRole('redaktur');
            $this->command->info('✅ Redaktur role assigned to redaktur@admin.com');
        }

        $reporterUser = User::where('email', 'reporter@admin.com')->first();
        if ($reporterUser) {
            $reporterUser->assignRole('reporter');
            $this->command->info('✅ Reporter role assigned to reporter@admin.com');
        }

        $this->command->newLine();
        $this->command->info('🎉 Roles & Permissions setup completed!');
        $this->command->newLine();
        
        // Display summary table
        $this->command->table(
            ['Role', 'Permissions Count', 'Description'],
            [
                ['admin', $admin->permissions->count(), 'Full system access'],
                ['redaktur', $redaktur->permissions->count(), 'Editorial management & approval'],
                ['reporter', $reporter->permissions->count(), 'Content creation (own articles)'],
            ]
        );
    }
}
