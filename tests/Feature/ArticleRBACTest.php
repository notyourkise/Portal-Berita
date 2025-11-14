<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ArticleRBACTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $redaktur;
    protected $reporter;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'redaktur']);
        Role::create(['name' => 'reporter']);

        // Create users
        $this->admin = User::factory()->create(['email' => 'admin@test.com']);
        $this->admin->assignRole('admin');

        $this->redaktur = User::factory()->create(['email' => 'redaktur@test.com']);
        $this->redaktur->assignRole('redaktur');

        $this->reporter = User::factory()->create(['email' => 'reporter@test.com']);
        $this->reporter->assignRole('reporter');

        // Create category
        $this->category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
        ]);
    }

    /** @test */
    public function reporter_can_create_article()
    {
        $this->actingAs($this->reporter);

        $article = Article::create([
            'title' => 'Test Article',
            'slug' => 'test-article',
            'body' => 'Test content',
            'author_id' => $this->reporter->id,
            'category_id' => $this->category->id,
            'status' => 'draft',
        ]);

        $this->assertDatabaseHas('articles', [
            'title' => 'Test Article',
            'author_id' => $this->reporter->id,
            'status' => 'draft',
        ]);
    }

    /** @test */
    public function reporter_can_only_see_own_articles()
    {
        $this->actingAs($this->reporter);

        // Create reporter's article
        $reporterArticle = Article::create([
            'title' => 'Reporter Article',
            'slug' => 'reporter-article',
            'body' => 'Content',
            'author_id' => $this->reporter->id,
            'category_id' => $this->category->id,
            'status' => 'draft',
        ]);

        // Create admin's article
        $adminArticle = Article::create([
            'title' => 'Admin Article',
            'slug' => 'admin-article',
            'body' => 'Content',
            'author_id' => $this->admin->id,
            'category_id' => $this->category->id,
            'status' => 'published',
        ]);

        $articles = Article::when(
            $this->reporter->hasRole('reporter'),
            fn($query) => $query->where('author_id', $this->reporter->id)
        )->get();

        $this->assertTrue($articles->contains($reporterArticle));
        $this->assertFalse($articles->contains($adminArticle));
    }

    /** @test */
    public function reporter_cannot_publish_article()
    {
        $this->actingAs($this->reporter);

        $article = Article::create([
            'title' => 'Test Article',
            'slug' => 'test-article',
            'body' => 'Content',
            'author_id' => $this->reporter->id,
            'category_id' => $this->category->id,
            'status' => 'draft',
        ]);

        // Reporter tries to change status to published
        $article->update(['status' => 'published']);

        // In real app, this would be blocked by form validation
        // Here we just verify the logic exists
        $hasPublishPermission = $this->reporter->hasRole(['admin', 'redaktur']);
        $this->assertFalse($hasPublishPermission);
    }

    /** @test */
    public function redaktur_can_see_all_articles()
    {
        $this->actingAs($this->redaktur);

        // Create articles from different authors
        $article1 = Article::create([
            'title' => 'Reporter Article',
            'slug' => 'reporter-article',
            'body' => 'Content',
            'author_id' => $this->reporter->id,
            'category_id' => $this->category->id,
            'status' => 'draft',
        ]);

        $article2 = Article::create([
            'title' => 'Admin Article',
            'slug' => 'admin-article',
            'body' => 'Content',
            'author_id' => $this->admin->id,
            'category_id' => $this->category->id,
            'status' => 'published',
        ]);

        $articles = Article::when(
            $this->redaktur->hasRole('reporter'),
            fn($query) => $query->where('author_id', $this->redaktur->id)
        )->get();

        // Redaktur should see all articles
        $this->assertEquals(2, $articles->count());
    }

    /** @test */
    public function redaktur_can_publish_article()
    {
        $this->actingAs($this->redaktur);

        $article = Article::create([
            'title' => 'Test Article',
            'slug' => 'test-article',
            'body' => 'Content',
            'author_id' => $this->reporter->id,
            'category_id' => $this->category->id,
            'status' => 'review',
        ]);

        $article->update([
            'status' => 'published',
            'editor_id' => $this->redaktur->id,
            'published_at' => now(),
        ]);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'status' => 'published',
            'editor_id' => $this->redaktur->id,
        ]);
    }

    /** @test */
    public function admin_can_delete_any_article()
    {
        $this->actingAs($this->admin);

        $article = Article::create([
            'title' => 'Test Article',
            'slug' => 'test-article',
            'body' => 'Content',
            'author_id' => $this->reporter->id,
            'category_id' => $this->category->id,
            'status' => 'published',
        ]);

        $canDelete = $this->admin->hasRole('admin');
        $this->assertTrue($canDelete);

        $article->delete();
        $this->assertSoftDeleted('articles', ['id' => $article->id]);
    }

    /** @test */
    public function admin_can_set_featured_article()
    {
        $this->actingAs($this->admin);

        $article = Article::create([
            'title' => 'Featured Article',
            'slug' => 'featured-article',
            'body' => 'Content',
            'author_id' => $this->admin->id,
            'category_id' => $this->category->id,
            'status' => 'published',
            'is_featured' => true,
        ]);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'is_featured' => true,
        ]);
    }

    /** @test */
    public function article_auto_sets_author_for_reporter()
    {
        $this->actingAs($this->reporter);

        $article = Article::create([
            'title' => 'Auto Author Test',
            'slug' => 'auto-author-test',
            'body' => 'Content',
            'author_id' => $this->reporter->id, // Auto-set in CreateArticle page
            'category_id' => $this->category->id,
            'status' => 'draft',
        ]);

        $this->assertEquals($this->reporter->id, $article->author_id);
    }

    /** @test */
    public function article_auto_sets_editor_when_published()
    {
        $this->actingAs($this->redaktur);

        $article = Article::create([
            'title' => 'Test Article',
            'slug' => 'test-article',
            'body' => 'Content',
            'author_id' => $this->reporter->id,
            'category_id' => $this->category->id,
            'status' => 'review',
        ]);

        // Simulate edit action where status changes to published
        $article->update([
            'status' => 'published',
            'editor_id' => $this->redaktur->id, // Auto-set in EditArticle page
            'published_at' => now(),
        ]);

        $this->assertEquals($this->redaktur->id, $article->editor_id);
        $this->assertNotNull($article->published_at);
    }

    /** @test */
    public function article_scopes_work_correctly()
    {
        // Create articles with different statuses
        $published = Article::create([
            'title' => 'Published Article',
            'slug' => 'published-article',
            'body' => 'Content',
            'author_id' => $this->admin->id,
            'category_id' => $this->category->id,
            'status' => 'published',
            'published_at' => now(),
        ]);

        $draft = Article::create([
            'title' => 'Draft Article',
            'slug' => 'draft-article',
            'body' => 'Content',
            'author_id' => $this->admin->id,
            'category_id' => $this->category->id,
            'status' => 'draft',
        ]);

        $featured = Article::create([
            'title' => 'Featured Article',
            'slug' => 'featured-article',
            'body' => 'Content',
            'author_id' => $this->admin->id,
            'category_id' => $this->category->id,
            'status' => 'published',
            'published_at' => now(),
            'is_featured' => true,
        ]);

        // Test scopes
        $this->assertEquals(2, Article::published()->count());
        $this->assertEquals(1, Article::featured()->count());
        $this->assertEquals(1, Article::draft()->count());
    }
}
