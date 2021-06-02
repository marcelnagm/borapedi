<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClientRating extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
            Schema::create('clients_ratings', function (Blueprint $table) {
            $table->id();              
            $table->unsignedBigInteger('restaurant_id')->nullable(false);
            $table->string('name')->nullable(false);
            $table->integer('period')->nullable(false);
            $table->float('val')->nullable(false);                    
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
         Schema::dropIfExists('client_ratings');
    }
}
