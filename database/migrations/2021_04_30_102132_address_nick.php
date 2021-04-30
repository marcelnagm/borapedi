<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddressNick extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('address', function (Blueprint $table) {
            $table->string('nick') // Nome da coluna
                    ->nullable() // Preenchimento não obrigatório
                    ->after('id'); // Ordenado após a coluna "password"
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('address', function (Blueprint $table) {
            $table->dropColumn('nick');
        });
    }

}
