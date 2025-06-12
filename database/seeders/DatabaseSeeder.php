<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ShortUrl;
use App\Models\ShortUrlClick;
use Database\Seeders\TheaterDataSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TheaterDataSeeder::class
        ]);

        ShortUrl::factory(10)->create();

        ShortUrlClick::factory(30)->create();
    }
}
