<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ReviewImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(database_path('sql/gym_reviewimages.sql'));
        DB::statement($sql);
    }
}