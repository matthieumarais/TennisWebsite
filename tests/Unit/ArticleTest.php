<?php

namespace Tests\Unit;

use App\Http\Controllers\ArticleController;
use App\Models\Article;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\View\View;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_method_should_return_view_with_articles(): void
    {
        // Create some dummy articles to paginate
        Article::factory()->count(15)->create();

        // Create an instance of ArticleController
        $controller = new ArticleController();

        // Call the index method on the controller
        $response = $controller->index();

        // Vérifiez que la méthode index renvoie bien une vue
        $this->assertInstanceOf(View::class, $response);

        // Vérifiez que la vue contient la variable $articles
        $this->assertArrayHasKey('articles', $response->getData());

        // Assert that the response is a valid LengthAwarePaginator instance
        $this->assertInstanceOf(LengthAwarePaginator::class, $response->getData()['articles']);

        $this->assertCount(10, $response->getData()['articles']);
    }
}
