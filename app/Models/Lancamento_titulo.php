<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lancamento_titulo extends Model
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

    protected $table = 'lancamento_titulo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'id_titulo',
        'vl_lancamento',
        'id_lancamento_financeiro',
        'dt_lancamento',
        'id_user',
    ];

    
    public function user(){
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    public function lancamentoFinanceiro(){
        return $this->hasOne(Lancamento_financeiro::class, 'id', 'id_lancamento_financeiro');
    }
}
