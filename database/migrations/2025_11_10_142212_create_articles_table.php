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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('editor_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body');
            
            $table->string('cover_image')->nullable();
            $table->string('cover_image_caption')->nullable();
            
            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            // Status & Publishing
            $table->enum('status', ['draft', 'review', 'published', 'scheduled'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            
            // Stats
            $table->integer('views')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_headline')->default(false);
            $table->boolean('allow_comments')->default(true);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index('status');
            $table->index('published_at');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
