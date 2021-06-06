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
            'description' => 'Акция: Скидка'
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
