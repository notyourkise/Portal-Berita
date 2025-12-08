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
        // Untuk dropdown_items yang sudah dalam format JSON, 
        // kita tidak perlu alter table karena JSON sudah fleksibel
        // Kita hanya perlu update struktur data di aplikasi
        
        // Namun untuk memastikan, kita bisa tambah comment di column
        Schema::table('pages', function (Blueprint $table) {
            $table->json('dropdown_items')->nullable()->comment('Format: [{"label":"","icon":"","slug":"","content":""}]')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->json('dropdown_items')->nullable()->change();
        });
    }
};
