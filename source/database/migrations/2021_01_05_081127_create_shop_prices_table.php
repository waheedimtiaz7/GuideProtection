<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id')->default(0);
            $table->decimal('range_from', 11, 2)->default(0);
            $table->decimal('range_to', 11, 2)->default(0);
            $table->decimal('price', 11, 2)->default(0);
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
        Schema::dropIfExists('shop_prices');
    }
}
