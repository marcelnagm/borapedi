<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CouponClient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
           Schema::table('coupons', function (Blueprint $table) {
              $table->unsignedBigInteger('client_id')->nullable(true)
                    ->nullable() // Preenchimento não obrigatório
                    ->after('used_count'); // Ordenado após a coluna "password"
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
