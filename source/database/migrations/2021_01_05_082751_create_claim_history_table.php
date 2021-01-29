<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_history', function (Blueprint $table) {
            $table->id();
            $table->integer('claim_id')->default(0);
            $table->integer('user_id')->default(0);
            $table->string("reorder_trackingnumber")->nullable();
            $table->string("reorder_cartnumber")->nullable();
            $table->string("reorder_storenumber")->nullable();
            $table->string("reorder_status")->nullable();
            $table->string("gp_reorder_trackno")->nullable();            
            $table->date("hold_until_date")->nullable(); 
            $table->string("claim_status")->nullable();
            $table->string("claim_rep")->nullable();
            $table->text('notes')->nullable();            
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
        Schema::dropIfExists('claim_history');
    }
}
