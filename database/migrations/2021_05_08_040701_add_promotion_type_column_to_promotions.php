<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPromotionTypeColumnToPromotions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->bigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('promotions_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropColumn('type_id');
        });
    }
}
