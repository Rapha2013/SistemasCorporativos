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
            'id_lancamento_financeiro' => $titulo->id_operacao_financeira,
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

        $lista = $lancamento_titulo->with(['user', 'lancamentoFinanceiro'])->get();

        return response()->json($lista, 200);
    }


    public function listar()
    {
        $titulo = new Titulo();

        $lista = $titulo->with(['cliente', 'lancamentoTitulo.lancamentoFinanceiro', 'lancamentoTitulo.user'])->get();

        return response()->json($lista, 200);
    }


    public function createLancamento(Lancamento_titulo $lancamento_titulo, Titulo $titulos, Request $request)
    {

        $existe = $titulos->where('id', $request->id_titulo)->exists();

        if (!$existe) {
            return response()->json('Erro: Titulo não encontrado!', 402);
        }

        $titulo = $titulos->where('id', $request->id_titulo)->first();


        if ($titulo->situacao == 'F') {
            return response()->json('Erro: Titulo já foi finalizado!', 402);
        }


        if ($request->vl_lancamento > $titulo->vl_titulo) {
            return response()->json('Erro: Valor do lançamento maior que do titulo!', 402);
        }

        $totalLacamento = $lancamento_titulo->selectRaw("SUM(vl_lancamento) AS qtd_lancados")->where('id_titulo', $request->id_titulo)->where('id_lancamento_financeiro', $request->id_lancamento_financeiro)->get()[0];


        if ($totalLacamento->qtd_lancados + $request->vl_lancamento > $titulo->vl_titulo) {

            return response()->json('Erro: Valor do lançamento maior que do titulo!', 402);
        }


        $lancamento = $lancamento_titulo->create([
            'id_titulo' => $request->id_titulo,
            'vl_lancamento' => $request->vl_lancamento,
            'id_lancamento_financeiro' => $request->id_lancamento_financeiro,
            'dt_lancamento' => date('Y-m-d H:i:s'),
            'id_user' => $request->id_usuario
        ]);


        if (!$lancamento) {
            return response()->json('Erro ao lancar o titulo!', 402);
        }

        $totalLacamentoTitulo = $lancamento_titulo->selectRaw("SUM(vl_lancamento) AS qtd_lancados")->where('id_titulo', $request->id_titulo)->where('id_lancamento_financeiro', $request->id_lancamento_financeiro)->get()[0];

        if ($totalLacamentoTitulo->qtd_lancados != null && $totalLacamentoTitulo->qtd_lancados == $titulo->vl_titulo) {

            $titulo->update([
                'situacao' => 'F',
                'dt_liquidacao' => date('Y-m-d H:i:s')
            ]);
        }

        if ($titulo->vl_titulo - $totalLacamentoTitulo->qtd_lancados == 0) {
            return response()->json('Titulo foi pago completamente e finalizado!', 200);
        }


        return response()->json('Falta ser pago ainda: ' . $titulo->vl_titulo - $totalLacamentoTitulo->qtd_lancados, 200);
    }


    public function getLancamento(Lancamento_titulo $lancamento_titulo, $id)
    {


        $existe = $lancamento_titulo->where('id_titulo', $id)->exists();


        if (!$existe) {
            return response()->json('Titulo não encontrado!', 402);
        }


        $lancamentos = $lancamento_titulo->where('id_titulo', $id)->with(['user', 'lancamentoFinanceiro'])->get();

        return response()->json($lancamentos, 200);
    }


    public function getTitulo(Titulo $titulos, $id)
    {

        $titulo = $titulos->where('id', $id)->with(['operacaoFinanceira', 'lancamentoTitulo.lancamentoFinanceiro', 'lancamentoTitulo.user', 'cliente'])->get();

        // $titulo = $titulos->join('operacao_financeira', 'titulo.id_operacao_financeira', 'operacao_financeira.id')
        //                   ->join('cliente', 'titulo.id_cliente_fornecedor', 'cliente.id')
        //                   ->selectRaw("
        //                   titulo.id, 
        //                   descricao, 
        //                   dt_lancamento,
        //                   dt_vencimento,
        //                   dt_liquidacao,
        //                   operacao_financeira.description as operacao,
        //                   cliente.name as nome_cliente
        //                   ")
        //                   ->where('titulo.id', $id)
        //                   ->get();

        return response()->json($titulo, 200);
    }
}
