<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->string('product_name');
            $table->decimal('price', 10, 2);
            $table->unsignedBigInteger('company_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('cascade');
=======
            $table->string('name');
            $table->unsignedBigInteger('company_id');
            $table->decimal('price', 8, 2);
            $table->integer('stock');
            $table->text('comment')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
>>>>>>> sub
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
}