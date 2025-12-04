<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== FIXING USER ROLES ===\n\n";

// Clear cache first
app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
echo "✅ Permission cache cleared\n\n";

// Assign Admin role
$adminUser = \App\Models\User::where('email', 'admin@admin.com')->first();
if ($adminUser) {
    $adminUser->syncRoles(['admin']);
    echo "✅ Admin role assigned to admin@admin.com\n";
    echo "   Permissions: " . $adminUser->getAllPermissions()->count() . "\n";
} else {
    echo "❌ Admin user not found\n";
}

// Assign Redaktur role
$redakturUser = \App\Models\User::where('email', 'redaktur@admin.com')->first();
if ($redakturUser) {
    $redakturUser->syncRoles(['redaktur']);
    echo "✅ Redaktur role assigned to redaktur@admin.com\n";
    echo "   Permissions: " . $redakturUser->getAllPermissions()->count() . "\n";
} else {
    echo "❌ Redaktur user not found\n";
}

// Assign Reporter role
$reporterUser = \App\Models\User::where('email', 'reporter@admin.com')->first();
if ($reporterUser) {
    $reporterUser->syncRoles(['reporter']);
    echo "✅ Reporter role assigned to reporter@admin.com\n";
    echo "   Permissions: " . $reporterUser->getAllPermissions()->count() . "\n";
} else {
    echo "❌ Reporter user not found\n";
}

echo "\n=== VERIFICATION ===\n\n";

// Verify Reporter
$reporter = \App\Models\User::where('email', 'reporter@admin.com')->first();
if ($reporter) {
    echo "👤 REPORTER:\n";
    echo "   Role: " . $reporter->getRoleNames()->first() . "\n";
    echo "   Can create articles? " . ($reporter->can('create_articles') ? '✅ YES' : '❌ NO') . "\n";
    echo "   Can view own articles? " . ($reporter->can('view_own_articles') ? '✅ YES' : '❌ NO') . "\n";
}

echo "\n";

// Verify Redaktur
$redaktur = \App\Models\User::where('email', 'redaktur@admin.com')->first();
if ($redaktur) {
    echo "👤 REDAKTUR:\n";
    echo "   Role: " . $redaktur->getRoleNames()->first() . "\n";
    echo "   Can create articles? " . ($redaktur->can('create_articles') ? '✅ YES' : '❌ NO') . "\n";
    echo "   Can publish articles? " . ($redaktur->can('publish_articles') ? '✅ YES' : '❌ NO') . "\n";
}

echo "\n✅ Done!\n";
