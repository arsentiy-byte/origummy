<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertPromotionGiftTypeIntoPromotionTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('promotions_types')->insert([
            'name' => 'gift',
            'description' => 'Акция: Подарок'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('promotions_types')->where('name', 'gift')->delete();
    }
}
