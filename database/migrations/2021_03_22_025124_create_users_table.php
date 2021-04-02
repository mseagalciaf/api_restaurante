<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name',45);
            $table->string('email',45)->unique();
            $table->string('password');
            // llaves foraneas
            $table->unsignedBigInteger('role_id')->nullable();
            $table->unsignedBigInteger('sucursale_id');
            //Restricciones
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
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
        Schema::dropIfExists('users');
    }
}
