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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug")->unique();
            $table->unsignedDecimal("price",14,2);
            $table->string("thumbnail")->nullable();
            $table->unsignedSmallInteger("qty")->default(0);
            $table->longText("description")->nullable();
            $table->unsignedBigInteger("category_id");
            $table->foreign("category_id")->references("id")->on("categories");
//            $table->string("status");
//            $table->unsignedBigInteger('brand_id')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
