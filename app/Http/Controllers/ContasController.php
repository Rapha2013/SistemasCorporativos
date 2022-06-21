<?php

namespace App\Http\Controllers;

date_default_timezone_set('America/Sao_Paulo');

use App\Models\Lancamento_titulo;
use App\Models\Titulo;
use Illuminate\Http\Request;

class ContasController extends Controller
{

    public function createTitulo(Titulo $titulo, Request $request)
    {

        $create = $titulo->create([
            'id_operacao_financeira' => $request->id_operacao_financeira,
            'descricao' => $request->descricao,
            'dt_lancamento' => $request->dt_lancamento,
            'dt_vencimento' => $request->dt_vencimento,
            'id_cliente_fornecedor' => $request->id_cliente_fornecedor,
            'vl_titulo' => $request->vl_titulo,
            'nr_parcela' => $request->nr_parcela,
            'qt_parcela' => $request->qt_parcela,
            'observacoes' => $request->observacoes,
            'pr_multa' => $request->pr_multa,
            'situacao' => $request->situacao,
            'vl_multa_dia' => $request->vl_multa_dia,
            'id_conta_caixa' => $request->id_conta_caixa

        ]);

        if ($create) {
            $lancamentoTitulo = self::storeLancamentoTitulo($create);

            if ($lancamentoTitulo) {
                return response()->json('Titulo cadastrado com sucesso!', 200);
            }

            return response()->json('Erro ao gerar o titulo', 402);
        }

        return response()->json('Erro ao gerar o titulo', 402);
    }

    private function storeLancamentoTitulo($titulo)
    {
        $lancamento_titulo = new Lancamento_titulo();

        $createTitulo = $lancamento_titulo->create([
            'id_titulo' => $titulo->id,
            'vl_lancamento' => $titulo->vl_titulo,
            'id_lancamento_financeiro' => 1,
            'dt_lancamento' => $titulo->dt_lancamento,
            'id_user' => 1
        ]);

        if ($createTitulo) {
            return true;
        }

        return false;
    }

    public function listarTitulo()
    {
        $lancamento_titulo = new Lancamento_titulo();

        $lista = $lancamento_titulo->get();

        return response()->json($lista, 200);
    }
}
