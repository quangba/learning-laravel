<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('foods')->insert([
            'name' => 'abc',
            'description' => 'abc description',
            'count' => 10,
            'category_id' => 1,
            'image_path' => ''
        ]);
    }
}
