<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('shipping_address',100);
            $table->string('phone',10);
            $table->string('total');
            $table->string('observation',250)->nullable();
            $table->unsignedBigInteger('sucursale_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            //Restricciones llaves foraneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('sucursale_id')->references('id')->on('sucursales')->onDelete('set null');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
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
        Schema::dropIfExists('sales');
    }
}
