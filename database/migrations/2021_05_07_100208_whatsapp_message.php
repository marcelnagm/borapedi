<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WhatsappMessage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          Schema::create('whatsapp_message', function (Blueprint $table) {
            $table->id();              
            $table->unsignedBigInteger('restorant_id')->nullable(false);
            $table->string('parameter')->nullable(false);
            $table->string('message')->nullable(false);                    
            $table->timestamps();
            $table->index(['restorant_id', 'parameter']);
            $table->unique(['restorant_id', 'parameter']);
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
          Schema::dropIfExists('whatsapp_message');
    }
}
