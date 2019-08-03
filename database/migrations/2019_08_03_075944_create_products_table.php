<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string("name");
            $table->string("brand")->nulleable()->default(null);
            $table->bigInteger("category")->unsigned();
            $table->double("public_price");
            $table->double("major_price");
            $table->double("provider_price");
            $table->string("code");
            $table->bigInteger("provider")->unsigned()->nulleable()->default(null);
            $table->tinyInteger("sell_type");
            $table->text("description");
            $table->integer("stock");
            $table->string("image");
            $table->foreign("category")->references("id")->on("categories");
            $table->foreign("provider")->references("id")->on("providers");
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
        Schema::dropIfExists('products');
    }
}
