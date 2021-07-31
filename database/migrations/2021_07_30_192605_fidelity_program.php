<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FidelityProgram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::drop('fidelity_program');
        Schema::create('fidelity_program', function (Blueprint $table) {
            $table->id();                          
            $table->unsignedBigInteger('restaurant_id')->nullable(false);
            $table->boolean('active')->defaul(0)->nullable(false);            
            $table->text('description')->defaul('Vazio');            
            $table->float('target')->defaul(0);
            $table->float('reward')->defaul(0);
            $table->boolean('type')->defaul(0);            
            $table->date('active_from')->nullable(false);            
            $table->date('active_to')->nullable(false);            
            $table->timestamps();
            $table->foreign('restaurant_id')->references('id')->on('restorants');
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
