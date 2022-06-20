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
        Schema::create('titulo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_operacao_financeira')->constrained('operacao_financeira');
            $table->string('descricao');
            $table->timestamp('dt_lancamento')->nullable(false);
            $table->timestamp('dt_vencimento');
            $table->timestamp('dt_liquidacao');
            $table->foreignId('id_cliente_fornecedor')->constrained('cliente')->nullable(false);
            $table->decimal('vl_titulo', 14,2)->nullable(false);
            $table->integer('nr_parcela')->nullable(false);
            $table->integer('qt_parcela')->nullable(false);
            $table->string('observacoes');
            $table->decimal('pr_multa', 14,2)->nullable(false);
            $table->string('situacao');
            $table->decimal('vl_multa_dia', 14,2)->nullable(false);
            $table->foreignId('id_conta_caixa')->constrained('conta_caixa')->nullable(false);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('titulo');
    }
};
