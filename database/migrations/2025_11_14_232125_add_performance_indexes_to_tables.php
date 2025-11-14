<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add performance indexes to frequently queried columns
     */
    public function up(): void
    {
        // Articles table indexes
        Schema::table('articles', function (Blueprint $table) {
            // Index for slug lookups (used in route model binding)
            $table->index('slug', 'idx_articles_slug');
            
            // Index for published_at (used in ordering and filtering published articles)
            $table->index('published_at', 'idx_articles_published_at');
            
            // Index for category_id (used in joins and filtering by category)
            $table->index('category_id', 'idx_articles_category_id');
            
            // Index for status (used in filtering by status)
            $table->index('status', 'idx_articles_status');
            
            // Index for author_id (used in filtering articles by author)
            $table->index('author_id', 'idx_articles_author_id');
            
            // Index for views (used in sorting popular articles)
            $table->index('views', 'idx_articles_views');
            
            // Index for is_featured (used in filtering featured articles)
            $table->index('is_featured', 'idx_articles_is_featured');
            
            // Composite index for published articles ordered by date
            $table->index(['status', 'published_at'], 'idx_articles_status_published_at');
            
            // Composite index for category + published articles
            $table->index(['category_id', 'status', 'published_at'], 'idx_articles_cat_status_pub');
        });

        // Categories table indexes
        Schema::table('categories', function (Blueprint $table) {
            // Index for slug lookups
            $table->index('slug', 'idx_categories_slug');
            
            // Index for is_active (used in filtering active categories)
            $table->index('is_active', 'idx_categories_is_active');
            
            // Index for order (used in sorting categories)
            $table->index('order', 'idx_categories_order');
            
            // Composite index for active categories ordered
            $table->index(['is_active', 'order'], 'idx_categories_active_order');
        });

        // Tags table indexes
        Schema::table('tags', function (Blueprint $table) {
            // Index for slug lookups
            $table->index('slug', 'idx_tags_slug');
            
            // Index for name (used in searching tags)
            $table->index('name', 'idx_tags_name');
        });

        // Article-Tag pivot table indexes
        Schema::table('article_tag', function (Blueprint $table) {
            // Composite indexes for relationships
            $table->index('article_id', 'idx_article_tag_article_id');
            $table->index('tag_id', 'idx_article_tag_tag_id');
        });

        // Users table indexes
        Schema::table('users', function (Blueprint $table) {
            // Email already has unique index, but add index for name if needed
            $table->index('name', 'idx_users_name');
        });

        // Pages table indexes
        Schema::table('pages', function (Blueprint $table) {
            // Index for slug lookups
            $table->index('slug', 'idx_pages_slug');
            
            // Index for is_active
            $table->index('is_active', 'idx_pages_is_active');
            
            // Index for order
            $table->index('order', 'idx_pages_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Articles table - drop indexes
        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex('idx_articles_slug');
            $table->dropIndex('idx_articles_published_at');
            $table->dropIndex('idx_articles_category_id');
            $table->dropIndex('idx_articles_status');
            $table->dropIndex('idx_articles_author_id');
            $table->dropIndex('idx_articles_views');
            $table->dropIndex('idx_articles_is_featured');
            $table->dropIndex('idx_articles_status_published_at');
            $table->dropIndex('idx_articles_cat_status_pub');
        });

        // Categories table - drop indexes
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('idx_categories_slug');
            $table->dropIndex('idx_categories_is_active');
            $table->dropIndex('idx_categories_order');
            $table->dropIndex('idx_categories_active_order');
        });

        // Tags table - drop indexes
        Schema::table('tags', function (Blueprint $table) {
            $table->dropIndex('idx_tags_slug');
            $table->dropIndex('idx_tags_name');
        });

        // Article-Tag pivot table - drop indexes
        Schema::table('article_tag', function (Blueprint $table) {
            $table->dropIndex('idx_article_tag_article_id');
            $table->dropIndex('idx_article_tag_tag_id');
        });

        // Users table - drop indexes
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_name');
        });

        // Pages table - drop indexes
        Schema::table('pages', function (Blueprint $table) {
            $table->dropIndex('idx_pages_slug');
            $table->dropIndex('idx_pages_is_active');
            $table->dropIndex('idx_pages_order');
        });
    }
};
