<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sql = file_get_contents(database_path('sql/gym_rooms.sql'));
        DB::statement($sql);
    }
}
