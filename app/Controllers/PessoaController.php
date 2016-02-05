<?php

namespace App\Controllers;

use DB;
use Cache;
use App\Models\Indice;
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
                ->select(DB::raw('CPF as Nome'), DB::raw('CPFcut as CPF'), DB::raw('SUM(Valor) as Valor'))
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
            'pessoas' => Servidor::where([
                        'COD_ORG_EXERCICIO' => '26244', #COD UFRGS
                        'CPFcut' => $cpf,
                    ])->get(),
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
            'alert' => strlen($cpf) != 11,
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
            'items' => Indice::like($term)
                        ->select('Nome', 'link', 'Valor')
                        ->take(50)
                        ->get(),
            'link' => 'search',
            'title' => 'Busca por '.$term,
        ]);
    }

    public function fetch($cpf)
    {

        $url = "http://www.portaldatransparencia.gov.br/servidores/Servidor-ListaServidores.asp?TextoPesquisa=$cpf";

        if (!is_numeric($cpf)) return redirect($url.'#fail');
        
        $pt_content = Cache::remember('portaldatransparencia-'.$cpf, 600, function() use ($url) {
            return file_get_contents($url);
        });        

        $pattern = '/Servidor-DetalhaServidor[^>]*>([\w\s]*)/';
        preg_match($pattern, $pt_content, $matches);

        if (isset($matches[1])) {
            $nome = trim($matches[1]);
            $affectedServidor = DB::update("update ServidoresExecutivo set CPFcut = :cpf where COD_ORG_EXERCICIO = 26244 and Nome = :nome", ['cpf' => $cpf, 'nome' => $nome]);
            if ($affectedServidor) {
                $affectedIndex = DB::update("update faurgsIndex set link = CONCAT('pessoa/',:cpf) where Nome = :nome or REPLACE(REPLACE(Nome,'.',''),'-','') = :cpfcut", ['cpf' => $cpf, 'nome' => $nome, 'cpfcut' => $cpf]);
                $affectedFaurgs = DB::update("update faurgsPagamentosPF set CPFcut = :cpfcut where REPLACE(REPLACE(CPF,'.',''),'-','') = :cpf", ['cpfcut' => $cpf, 'cpf' => $cpf]);
            }
        }

        return redirect($url.'#success');
    }

}
