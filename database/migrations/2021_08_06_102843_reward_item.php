<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RewardItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::dropIfExists('reward_item');
        Schema::create('reward_item', function (Blueprint $table) {
            $table->id();                          
            $table->unsignedBigInteger('restaurant_id')->nullable(false);
            $table->unsignedBigInteger('item_id')->nullable(false);
            $table->unsignedBigInteger('program_id')->nullable(false);
            
            $table->timestamps();
            $table->foreign('restaurant_id')->references('id')->on('restorants');
            $table->foreign('program_id')->references('id')->on('items');
            $table->foreign('item_id')->references('id')->on('fidelity_program');
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
