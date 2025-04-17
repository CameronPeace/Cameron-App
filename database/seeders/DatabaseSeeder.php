<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        ShortUrlClick::factory(30)->create();
    }
}
