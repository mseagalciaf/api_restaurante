<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSucursaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sucursale', function (Blueprint $table) {
            $table->id();
            //Llave foraneas
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('sucursale_id');
            //Restricciones
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('sucursale_id')->references('id')->on('sucursales')->onDelete('cascade');
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
        Schema::dropIfExists('product_sucursale');
    }
}
