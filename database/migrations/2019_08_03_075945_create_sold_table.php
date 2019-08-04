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
            $table->bigInteger("user")->unsigned();            
            $table->bigInteger("product")->unsigned();
            $table->integer("quantity");
            $table->integer("disccount");
            $table->float("payed");
            $table->tinyInteger("payment_method");
            $table->timestamps();
            $table->foreign("user")->references("id")->on("users")->onDelete("cascade");
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
