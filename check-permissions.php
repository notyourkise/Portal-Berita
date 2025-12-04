<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== CHECKING USER PERMISSIONS ===\n\n";

// Check Reporter
$reporter = \App\Models\User::where('email', 'reporter@admin.com')->first();
if ($reporter) {
    echo "👤 REPORTER ({$reporter->email}):\n";
    echo "Roles: " . $reporter->getRoleNames()->implode(', ') . "\n";
    echo "Permissions:\n";
    foreach ($reporter->getAllPermissions() as $perm) {
        echo "  - {$perm->name}\n";
    }
    echo "\nCan create articles? " . ($reporter->can('create_articles') ? '✅ YES' : '❌ NO') . "\n";
} else {
    echo "❌ Reporter user not found\n";
}

echo "\n" . str_repeat('-', 50) . "\n\n";

// Check Redaktur
$redaktur = \App\Models\User::where('email', 'redaktur@admin.com')->first();
if ($redaktur) {
    echo "👤 REDAKTUR ({$redaktur->email}):\n";
    echo "Roles: " . $redaktur->getRoleNames()->implode(', ') . "\n";
    echo "Permissions:\n";
    foreach ($redaktur->getAllPermissions() as $perm) {
        echo "  - {$perm->name}\n";
    }
    echo "\nCan create articles? " . ($redaktur->can('create_articles') ? '✅ YES' : '❌ NO') . "\n";
} else {
    echo "❌ Redaktur user not found\n";
}

echo "\n" . str_repeat('-', 50) . "\n\n";

// Check all roles
echo "📋 ALL ROLES IN DATABASE:\n";
foreach (\Spatie\Permission\Models\Role::all() as $role) {
    echo "  - {$role->name} ({$role->permissions->count()} permissions)\n";
}

echo "\n📋 ALL PERMISSIONS IN DATABASE:\n";
foreach (\Spatie\Permission\Models\Permission::all() as $perm) {
    echo "  - {$perm->name}\n";
}
