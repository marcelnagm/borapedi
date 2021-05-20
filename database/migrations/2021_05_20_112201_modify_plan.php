<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('plan', function (Blueprint $table) {
            $table->integer('driver_own') // Nome da coluna
                    ->nullable(false) // Preenchimento não obrigatório
                    ->after('enable_ordering'); // Ordenado após a coluna "password"
            $table->integer('local_table') // Nome da coluna
                    ->nullable(false) // Preenchimento não obrigatório
                    ->after('driver_own'); // Ordenado após a coluna "password"
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
        Schema::table('address', function (Blueprint $table) {
            $table->dropColumn('driver_own');
            $table->dropColumn('local_table');
        });
    }
}
