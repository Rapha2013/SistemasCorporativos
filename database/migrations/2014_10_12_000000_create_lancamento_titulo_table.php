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
        Schema::create('lancamento_titulo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_titulo')->constrained('titulo');
            $table->decimal('vl_lancamento', 14,2)->nullable(false);
            $table->foreignId('id_lancamento_financeiro')->constrained('lancamento_financeiro');
            $table->timestamp('dt_lancamento');
            $table->foreignId('id_user')->constrained('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lancamento_titulo');
    }
};
