<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_emails', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('claim_id')->default(0);
            $table->integer('user_id')->nullable();
            $table->integer('email_id')->nullable();
            $table->integer('claim_rep')->nullable();
            $table->string('to_email')->nullable();
            $table->string('to_subject')->nullable();
            $table->text('to_body')->nullable();
            $table->integer('email_type')->default(0);
            $table->dateTime('recorded_at')->nullable();       
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_emails');
    }
}
