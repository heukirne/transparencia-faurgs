<?php

namespace App\Controllers;

use DB;
use Cache;
use App\Models\Orgaos;
use App\Models\Projetos;
use App\Models\PagamentosFis;
use App\Models\PagamentosJur;
use App\Models\ModelHelper;

class ProjetoController extends Controller
{

    public function detail($id)
    {
        return view('projeto', [
            'pessoas' => PagamentosFis::groupBy('TipoDespesa','TipoPagamento','CPF','CPFcut')
                            ->select('TipoDespesa','TipoPagamento','CPF','CPFcut', DB::raw('SUM(Valor) as Total'))
                            ->where('idProjeto', $id)
                            ->orderBy('Total', 'desc')
                            ->get(),
            'empresas' => PagamentosJur::groupBy('NomeEmpresa','TipoDespesa','CNPJ')
                            ->select('NomeEmpresa', 'TipoDespesa', 'CNPJ', DB::raw('SUM(Valor) as Total'))
                            ->where('idProjeto', $id)
                            ->orderBy('Total', 'desc')
                            ->get(),
            'projeto' => Projetos::find($id),
        ]);
    }

    public function index()
    {

        $projetos = Cache::remember('projetos', 600, function() {
            return Projetos::orderBy('Valor', 'desc')->take(1000)->get();
        });

        return view('items', [
            'items' => $projetos,
            'link' => 'projeto',
            'title' => '1000 Projetos',
        ]);
    }

}
