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
        $table->Integer('product_id')->unsigned()->nullable();
        $table->Integer('pharmacy_id')->unsigned()->nullable();
        $table->Integer('warehouse_id')->unsigned()->nullable();
        $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('pharmacy_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('warehouse_id')->references('id')->on('users')->onDelete('cascade');

    });

    }

    /**
     * Reverse the migrations.78
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
