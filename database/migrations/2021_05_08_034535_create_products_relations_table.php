<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_relations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('main_product_id');
            $table->bigInteger('related_product_id');

            $table->foreign('main_product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('related_product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_relations');
    }
}
