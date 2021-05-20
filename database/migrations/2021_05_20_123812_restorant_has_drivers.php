<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RestorantHasDrivers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        
          Schema::create('restorant_has_drivers', function (Blueprint $table) {
            $table->id();              
            $table->unsignedBigInteger('restorant_id')->nullable(false);
            $table->unsignedBigInteger('driver_id')->nullable(false);
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
        Schema::dropIfExists('restorant_has_drivers');
    }
}
