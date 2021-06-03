<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClientHasRatings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
           Schema::create('client_has_rating', function (Blueprint $table) {
            $table->id();              
            $table->unsignedBigInteger('restaurant_id')->nullable(false);                 
            $table->unsignedBigInteger('client_id')->nullable(false);                 
            $table->unsignedBigInteger('rating_id')->nullable(true)->default(NULL);                 
            $table->float('spent')->nullable(false)->default(0);                 
            $table->integer('orders')->nullable(false)->default(0);                 
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
        //
       Schema::dropIfExists('client_has_rating'); 
    }
}
