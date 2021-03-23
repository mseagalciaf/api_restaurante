<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupModifierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_modifier', function (Blueprint $table) {
            $table->id();
            //llaves foraneas
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('modifier_id');
            //Restricciones
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('modifier_id')->references('id')->on('modifiers')->onDelete('cascade');
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
        Schema::dropIfExists('group_modifier');
    }
}
