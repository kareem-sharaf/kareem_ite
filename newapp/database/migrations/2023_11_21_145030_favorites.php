<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('product_id')->unsigned();
        $table->integer('pharmacie_id')->unsigned();
        $table->integer('warehouse_id')->unsigned();
        $table->timestamps();


        $table->foreign('pharmacie_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('warehouse_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
