<?php

namespace App\Controllers;

use DB;
use Cache;
use App\Models\Servidor;
use App\Models\Projetos;
use App\Models\PagamentosFis;
use Illuminate\Http\Request;

class PessoaController extends Controller
{

    public function index()
    {

        $pessoas = Cache::remember('pessoas', 600, function() {
            return PagamentosFis::groupBy('CPF','CPFcut')
                ->select(DB::raw('CPF as Nome'), DB::raw('CPFcut as id'), DB::raw('SUM(Valor) as Valor'))
                ->take(1000)
                ->orderBy('Valor', 'desc')
                ->get();
        });

        return view('items', [
            'items' => $pessoas,
            'link' => 'pessoa',
            'title' => '1000 Pessoas',
        ]);
    }

    public function detail($cpf)
    {
        return view('pessoa', [
            'pessoa' => Servidor::where([
                        'COD_ORG_EXERCICIO' => '26244', #COD UFRGS
                        'CPFcut' => $cpf,
                    ])->first(),
            'projetos' => PagamentosFis::where('CPFcut', $cpf)
                            ->groupBy('CPF','TipoPagamento', 'CPFcut','idProjeto', 'TipoDespesa')
                            ->select('CPF','TipoPagamento', 'CPFcut','idProjeto', 'TipoDespesa', DB::raw('SUM(Valor) as Total'))
                            ->orderBy('CPF', 'desc')
                            ->orderBy('Total', 'desc')
                            ->with('projeto')
                            ->get(),
            'totals' => PagamentosFis::where('CPFcut', $cpf)
                            ->groupBy('CPF', 'CPFcut')
                            ->select(
                                    'CPF',
                                    'CPFcut',
                                    DB::raw('SUM(Valor) as Total'),
                                    DB::raw('MIN(YEAR(Data)) as AnoIni'),
                                    DB::raw('MAX(YEAR(Data)) as AnoFim'),
                                    DB::raw('COUNT(DISTINCT(idProjeto)) as Projetos')
                                )
                            ->orderBy('Total', 'desc')
                            ->get(),
        ]);
    }

    public function coordenador($nome)
    {
        $nome = urldecode($nome);

        return view('items', [
            'items' => Projetos::where('Coordenador', $nome)
                        ->orderBy('Valor', 'desc')
                        ->get(),
            'link' => 'projeto',
            'title' => $nome,
        ]);
    }

    public function search(Request $request)
    {
        $term = $request->input('q');

        return view('items', [
            'items' => Servidor::like($term)
                        ->select('Nome', DB::raw('CPFcut as id'), DB::raw('DESCRICAO_CARGO as Valor'))
                        ->where('COD_ORG_EXERCICIO' ,'26244')  #COD UFRGS
                        ->take(50)
                        ->get(),
            'link' => 'pessoa',
            'title' => 'Busca por '.$term,
        ]);
    }

}
