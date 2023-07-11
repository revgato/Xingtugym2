<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(RoomImageSeeder::class);
        $this->call(ReviewSeeder::class);
        // $this->call(ReviewImageSeeder::class);
        $this->call(ReviewReactSeeder::class);
    }
}
