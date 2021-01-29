<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->string("incident_type")->nullable();
            $table->text("incident_description")->nullable();
            $table->string("store_id")->nullable();
            $table->integer("shop_id")->nullable();
            $table->string("store_ordernumber")->nullable();
            $table->string("cart_ordernumber")->nullable();
            $table->string("cart_trackingnumber")->nullable();
            $table->integer("order_id")->nullable();
            $table->dateTime("orderdate")->nullable();
            $table->string("customer_reported_trackno")->nullable();
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
            $table->string("reorder_trackingnumber")->nullable();
            $table->string("reorder_cartnumber")->nullable();
            $table->string("reorder_storenumber")->nullable();
            $table->string("reorder_status")->nullable();
            $table->string("claim_status")->nullable();
            $table->integer("claim_rep")->nullable();
            $table->string("gp_origord_shiptrackno")->nullable();
            $table->string("gp_reorderno")->nullable();
            $table->string("gp_reorder_trackno")->nullable();            
            $table->date("hold_until_date")->nullable();
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
        Schema::dropIfExists('claims');
    }
}
