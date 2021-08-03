<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Reward extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
//        Schema::drop('reward');
        Schema::create('reward', function (Blueprint $table) {
            $table->id();                          
            $table->unsignedBigInteger('program_id')->nullable(false);
            $table->unsignedBigInteger('client_id')->nullable(false);
            $table->timestamps();
            $table->foreign('program_id')->references('id')->on('fidelity_program');
            $table->foreign('client_id')->references('id')->on('users');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
