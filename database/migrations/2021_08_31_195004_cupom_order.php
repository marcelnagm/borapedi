<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CupomOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
           Schema::table('orders', function (Blueprint $table) {
              $table->unsignedBigInteger('coupom_id')->nullable(true)
                    ->after('client_id'); // Ordenado após a coluna "password"
              $table->foreign('coupom_id')->references('id')->on('coupons');
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
