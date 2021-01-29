<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('store_id')->nullable();
            $table->string('display_name')->nullable();
            $table->decimal('item_price', 11, 2)->default(0);
            $table->string('setup_status')->nullable();
            $table->string('store_url')->nullable();
            $table->string('shopify_name')->nullable();
            $table->string('cart_type')->nullable();
            $table->string('sales_rep')->nullable();
            $table->string('alex_rank')->nullable();
            $table->string('ups_acc_no')->nullable();
            $table->string('fedex_acc_no')->nullable();
            $table->string('usps_acc_no')->nullable();
            $table->string('dhl_acc_no')->nullable();
            $table->string('other_acc_no')->nullable();
            $table->string('primary_poc_firstname')->nullable();
            $table->string('primary_poc_lastname')->nullable();
            $table->string('primary_poc_phone')->nullable();
            $table->string('primary_poc_email')->nullable();
            $table->string('primary_poc_title')->nullable();             
             
            $table->dateTime('change_at')->nullable();
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
        Schema::dropIfExists('shops');
    }
}
