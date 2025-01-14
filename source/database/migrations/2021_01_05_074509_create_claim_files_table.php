<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_files', function (Blueprint $table) {
            $table->id();
            $table->integer('claim_id')->default(0);
            $table->integer('user_id')->nullable();
            $table->string('filename')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('uploaded_at')->nullable();       
            
                    
            
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
        Schema::dropIfExists('claim_files');
    }
}
