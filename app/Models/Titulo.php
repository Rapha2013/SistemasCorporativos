<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Titulo extends Model
{
    use HasFactory;

     /**
     * the Id associated with the partnert 
     *
     * @var int
     */

    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'titulo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'id_operacao_financeira',
        'descricao',
        'dt_lancamento',
        'dt_vencimento',
        'dt_liquidacao',
        'id_cliente_fornecedor',
        'vl_titulo',
        'nr_parcela',
        'qt_parcela',
        'observacoes',
        'pr_multa',
        'situacao',
        'vl_multa_dia',
        'id_conta_caixa'
    ];
}
