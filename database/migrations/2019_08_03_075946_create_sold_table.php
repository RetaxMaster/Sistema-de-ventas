<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sold', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("product")->unsigned();
            $table->integer("quantity");
            $table->float("payed");
            $table->bigInteger("sale")->unsigned();
            $table->timestamps();
            $table->foreign("sale")->references("id")->on("sales")->onDelete("cascade");
            $table->foreign("product")->references("id")->on("products")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sold');
    }
}
