<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MoneyChangeOrder extends Migration
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
            $table->integer('money_change') // Nome da coluna
                    ->nullable(false) // Preenchimento não obrigatório
                    ->after('payment_method'); // Ordenado após a coluna "password"           
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
