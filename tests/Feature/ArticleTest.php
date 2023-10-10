<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @var User $user */
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        Auth::login($this->user);
    }

    public function test_ok_on_edit_article(): void
    {
        $article = Article::factory()->create();

        $response = $this->get(route('admin.articles.edit', $article->id));
        $response->assertOk();
        $response->assertSee($article->title);
    }

    public function test_ko_on_edit_article(): void
    {
        $response = $this->get(route('admin.articles.edit', 0));
        $response->assertStatus(404);
    }

    public function test_error_on_create_article(): void
    {
        $response = $this->post(route('admin.articles.store'), [
            'title' => 'title One',
            'content' => null
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['content']);
        $response->assertSessionHasInput('title', 'title One');
    }

    public function test_success_on_create_article(): void
    {
        $response = $this->post(route('admin.articles.store'), [
            'title' => 'title One',
            'content' => 'content with min 1O letters'
        ]);

        $article = Article::first();

        $response->assertRedirect(route('admin.articles.edit', $article));
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');
        $this->assertCount(1, Article::all());
    }

    public function test_an_article_can_be_updated(): void
    {
        $this->post(route('admin.articles.store'), [
            'title' => 'title One',
            'content' => 'content with min 1O letters'
        ]);

        $article = Article::first();

        $response = $this->put(route('admin.articles.update', $article), [
            'title' => 'Update du 1er article',
            'content' => 'content du premier article modifié'
        ]);

        $this->assertEquals('Update du 1er article', Article::first()->title);
        $this->assertEquals("L'article a bien été modifié", session('success'));
        $this->assertNotEquals($article->content, Article::first()->content);
        $response->assertRedirect(route('admin.articles.index'));
        $response->assertSessionHas('success');

    }

    public function test_an_article_can_not_be_updated(): void
    {
        $this->post(route('admin.articles.store'), [
            'title' => 'title One',
            'content' => 'content with min 1O letters'
        ]);

        $article = Article::first();

        $response = $this->put(route('admin.articles.update', $article), [
            'title' => '',
            'content' => ''
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['title', 'content']);
        $response->assertSessionHasInput('title', '');
        $response->assertSessionHasInput('content', '');
        $this->assertCount(1, Article::all());
    }

    public function test_an_article_can__be_deleted(): void
    {
        $this->post(route('admin.articles.store'), [
            'title' => 'title One',
            'content' => 'content with min 1O letters'
        ]);

        $article = Article::first();

        $response = $this->delete(route('admin.articles.destroy', $article));

        $this->assertCount(0, Article::all());
        $response->assertRedirect(route('admin.articles.index'));
        $response->assertSessionHas('success');
        $this->assertEquals("L'article a bien été supprimé", session('success'));
    }
}
