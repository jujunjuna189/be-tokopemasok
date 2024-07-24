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
        Schema::create('store', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('store_user', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('store_id');
            $table->bigInteger('user_id');
            $table->timestamps();
        });

        Schema::create('store_product', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('store_id');
            $table->bigInteger('product_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store');
        Schema::dropIfExists('store_member');
    }
};
