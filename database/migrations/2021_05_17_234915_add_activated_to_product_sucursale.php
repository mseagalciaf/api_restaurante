<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActivatedToProductSucursale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_sucursale', function (Blueprint $table) {
            $table->boolean('activated')->after('sucursale_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_sucursale', function (Blueprint $table) {
            $table->dropColumn('activated');
        });
    }
}
