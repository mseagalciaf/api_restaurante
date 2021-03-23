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
            $table->string('direccion_envio',100);
            $table->string('telefono',10);
            $table->string('total');
            $table->string('observacion',150)->nullable();
            //llaves foraneas
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('sucursale_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            //Restricciones
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
