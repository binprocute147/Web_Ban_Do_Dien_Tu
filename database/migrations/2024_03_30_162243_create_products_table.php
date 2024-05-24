<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id'); // Khóa chính 
            $table->string('name', 255); // Tên sản phẩm (varchar(255))
            $table->unsignedBigInteger('manu_id'); // ID của hãng sản xuất (int 11)
            $table->unsignedBigInteger('type_id'); // ID của loại sản phẩm (int 11)
            $table->integer('price'); // Giá sản phẩm (int 10)
            $table->string('pro_image', 100); // Đường dẫn tới hình ảnh (varchar(100))
            $table->text('description')->nullable(); // Mô tả sản phẩm (text)
            $table->integer('sold_quantity'); // số lượng bán 
            $table->integer('product_view'); // số lượng xem 
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
