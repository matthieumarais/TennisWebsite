<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(10)->create();
        //User::factory(1)->unverified()->create();

        User::factory()->create([
            'email' => 'mqtthieu@gmail.com'
        ]);

        Article::factory(20)->create();
    }
}
