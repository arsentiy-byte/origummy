<?php

namespace Database\Seeders;

use App\Models\Category\Category;
use App\Models\Product\Product;
use App\Models\User;
use Hash;
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
        User::create([
            'username' => 'admin',
            'password' => Hash::make('1234'),
        ]);
    }
}
