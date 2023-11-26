<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('favorite_orders', function (Blueprint $table) {
            // Thêm cột 'category_id' và 'product_id' vào bảng 'favorite_orders'
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();

            // Tạo foreign key cho cả hai cột
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('favorite_orders', function (Blueprint $table) {
            // Xóa cột 'category_id' và 'product_id' khỏi bảng 'favorite_orders'
            $table->dropForeign(['category_id']);
            $table->dropForeign(['product_id']);
            $table->dropColumn(['category_id', 'product_id']);
        });
    }
};

