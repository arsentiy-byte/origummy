<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertPromotionDiscountTypeIntoPromotionTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('promotions_types')->insert([
            'name' => 'discount',
            'display_name' => 'Скидка',
            'description' => 'Акция: Скидка',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('promotions_types')->where('name', 'discount')->delete();
    }
}
