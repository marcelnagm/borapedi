<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Fideltity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     
        
        Schema::dropIfExists('fidelity_program');
        Schema::create('fidelity_program', function (Blueprint $table) {
            $table->id();                          
            $table->unsignedBigInteger('restaurant_id')->nullable(false);
            $table->boolean('active')->defaul(0)->nullable(false);            
            $table->boolean('type_target')->defaul(0);            
            $table->integer('target_orders')->defaul(0);
            $table->float('target_value')->defaul(0);
            $table->boolean('type_reward')->defaul(0);            
            $table->float('reward')->defaul(0);
            $table->boolean('type_coupon')->defaul(0);            
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
