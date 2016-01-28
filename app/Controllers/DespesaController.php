<?php

namespace App\Controllers;

use DB;
use Cache;
use App\Models\Orgaos;
use App\Models\Projetos;
use App\Models\ModelHelper;
use App\Models\PagamentosFis;
use App\Models\PagamentosJur;

class DespesaController extends Controller
{

    public function detail($tipo)
    {

		$tipo = ModelHelper::urlDecode($tipo);

        return view('items', [
            'items' => PagamentosFis::groupBy('CPF','CPFcut')
		                ->select(DB::raw('CPF as Nome'), DB::raw('CPFcut as id'), DB::raw('SUM(Valor) as Valor'))
		                ->take(1000)
		                ->orderBy('Valor', 'desc')
		                ->where('TipoDespesa', $tipo)
		                ->get(),
            'link' => 'pessoa',
            'title' => $tipo,
        ]);
    }

    public function index()
    {

        $despesas = Cache::remember('despesasFis', 600, function() {
            return PagamentosFis::groupBy('TipoDespesa')
            	->select('TipoDespesa as Nome', DB::raw('SUM(Valor) as Valor'))
            	->orderBy('Valor', 'desc')
            	->take(1000)
            	->get();
        });

        return view('items', [
            'items' => $despesas,
            'link' => 'despesa',
            'title' => '1000 Tipos de Despesas',
        ]);
    }

}
