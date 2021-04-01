<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryTax extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_tax', function (Blueprint $table) {
            $table->id();              
            $table->unsignedBigInteger('restaurant_id')->nullable(false);
            $table->float('distance')->nullable(false);
            $table->float('cost',)->nullable(false);                    
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
        Schema::dropIfExists('delivery_tax');
    }
}
