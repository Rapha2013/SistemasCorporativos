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
        Schema::create('operacao_financeira', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
        });

        // Insert some stuff
        DB::table('operacao_financeira')->insert(
            array(
                'description' => 'Contas a Pagar',
            )
        );

        // Insert some stuff
        DB::table('operacao_financeira')->insert(
            array(
                'description' => 'Contas a receber',
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
        Schema::dropIfExists('operacao_financeira');
    }
};
