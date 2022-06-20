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
        Schema::create('conta_caixa', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
        });

        // Insert some stuff
        DB::table('conta_caixa')->insert(
            array(
                'description' => 'Transferencia bancária',
            )
        );

        // Insert some stuff
        DB::table('conta_caixa')->insert(
            array(
                'description' => 'Boleto',
            )
        );

        // Insert some stuff
        DB::table('conta_caixa')->insert(
            array(
                'description' => 'Cartão de Crédito',
            )
        );

        // Insert some stuff
        DB::table('conta_caixa')->insert(
            array(
                'description' => 'Cartão de Débito',
            )
        );

        // Insert some stuff
        DB::table('conta_caixa')->insert(
            array(
                'description' => 'Pix',
            )
        );

        // Insert some stuff
        DB::table('conta_caixa')->insert(
            array(
                'description' => 'Caixinha',
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
        Schema::dropIfExists('conta_caixa');
    }
};
