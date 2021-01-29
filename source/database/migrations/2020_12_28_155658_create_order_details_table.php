<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->integer("order_id");
            $table->integer("cart_order_id")->nullable();
            $table->integer("cart_line_itemid")->nullable();
            $table->integer("cart_variantid")->nullable();
            $table->integer("cart_productid")->nullable();
            $table->string("cart_name")->nullable();
            $table->string("title")->nullable();
            $table->integer("qty")->default(0);
            $table->string("sku")->nullable();
            $table->float("final_unit_price", $total=11, $places=2);
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
        Schema::dropIfExists('order_details');
    }
}
