<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->boolean('show_in_navbar')->default(false)->after('is_active');
            $table->integer('navbar_order')->default(0)->after('show_in_navbar');
            $table->string('navbar_icon')->nullable()->after('navbar_order');
            $table->string('navbar_parent')->nullable()->after('navbar_icon'); // untuk dropdown/submenu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['show_in_navbar', 'navbar_order', 'navbar_icon', 'navbar_parent']);
        });
    }
};
