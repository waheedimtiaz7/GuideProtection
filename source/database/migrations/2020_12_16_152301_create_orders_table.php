<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("customer_firstname")->nullable();
            $table->string("customer_lastname")->nullable();
            $table->string("customer_email")->nullable();
            $table->string("customer_phone")->nullable();
            $table->string("shipping_addresss_1")->nullable();
            $table->string("shipping_addresss_2")->nullable();
            $table->string("shipping_city")->nullable();
            $table->string("shipping_state")->nullable();
            $table->string("shipping_zip")->nullable();
            $table->string("shipping_country")->nullable();     
            $table->string("shipping_carrier_method")->nullable();
            $table->string("store_ordernumber")->nullable();
            $table->string("store_id")->nullable();
            $table->dateTime("orderdate")->nullable();
            $table->string("order_status_url")->nullable();
            $table->string("cart_orderid")->nullable();
            $table->string("cart_cancelat")->nullable();
            $table->text("cart_cancelled_reason")->nullable();
            $table->string("cart_ship_trackno")->nullable();
            $table->float("final_order_price",$total=11, $places=2)->nullable();
            $table->float("final_order_tax", $total=11, $places=2)->nullable();
            $table->float("final_order_shipping",$total=11, $places=2)->nullable();
            $table->float("final_order_other",$total=11, $places=2)->nullable();
            $table->float("final_order_product_total",$total=11, $places=2)->nullable();

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
        Schema::dropIfExists('orders');
    }
}
