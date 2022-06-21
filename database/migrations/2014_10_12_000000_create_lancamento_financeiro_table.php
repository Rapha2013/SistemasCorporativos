<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lancamento_financeiro', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->string('sinal');
        });

        // Insert some stuff
        DB::table('lancamento_financeiro')->insert(
            array(
                'descricao' => 'Lançamento de contas a Pagar',
                'sinal' => 'C'
            )
        );

        // Insert some stuff
        DB::table('lancamento_financeiro')->insert(
            array(
                'descricao' => 'Lançamento de contas a Receber',
                'sinal' => 'D'
            )
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lancamento_financeiro');
    }
};
