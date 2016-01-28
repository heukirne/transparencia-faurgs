<?php

namespace App\Controllers;

use DB;
use Cache;
use App\Models\Orgaos;
use App\Models\Projetos;
use App\Models\PagamentosFis;
use App\Models\PagamentosJur;

class UnidadeController extends Controller
{

    public function index()
    {
        return view('items', [
            'items' => Orgaos::orderBy('Valor', 'desc')->get(),
            'link' => 'unidade',
            'title' => 'Todas as Unidades',
        ]);
    }

    public function unidade($id)
    {
        $Orgao = Orgaos::find($id);

        return view('items', [
            'items' => Projetos::where('idOrgao', $id)
                        ->orderBy('Valor', 'desc')
                        ->get(),
            'link' => 'projeto',
            'title' => $Orgao?$Orgao->Nome:'Sem descricao',
        ]);
    }

    public function projeto($id)
    {
        return view('projeto', [
            'pessoas' => PagamentosFis::groupBy('TipoDespesa','TipoPagamento','CPF','CPFcut')
                            ->select('TipoDespesa','TipoPagamento','CPF','CPFcut', DB::raw('SUM(Valor) as Total'))
                            ->where('idProjeto', $id)
                            ->orderBy('Total', 'desc')
                            ->get(),
            'empresas' => PagamentosJur::groupBy('NomeEmpresa','CNPJ')
                            ->select('NomeEmpresa', 'CNPJ', DB::raw('SUM(Valor) as Total'))
                            ->where('idProjeto', $id)
                            ->orderBy('Total', 'desc')
                            ->get(),
            'projeto' => Projetos::find($id),
        ]);
    }

    public function projetos()
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
