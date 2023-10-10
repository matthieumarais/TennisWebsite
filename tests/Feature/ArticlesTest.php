<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    /*public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }*/

    public function test_cant_connect_to_articles_without_registration(): void
    {
        $response = $this->get('/admin/articles');

        $response->assertStatus(302);
    }

    public function test_connect_to_articles_with_registration(): void
    {
        $user = \App\Models\User::factory()->create();

        Auth::login($user);

        $response = $this->get('/admin/articles');

        $response->assertStatus(200);
    }
}
