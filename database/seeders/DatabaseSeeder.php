<?php

namespace Database\Seeders;

use App\Models\Category\Category;
use App\Models\Product\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory(10)->create();
         Category::factory(8)->create();
         Product::factory(20)->create();
    }
}
