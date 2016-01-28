<?php

namespace App\Controllers;

use DB;
use Cache;
use App\Models\PagamentosJur;

class EmpresaController extends Controller
{

    public function index()
    {

        $empresas = Cache::remember('empresas', 600, function() {
            return PagamentosJur::groupBy('CNPJ','NomeEmpresa')
                    ->select(DB::raw('NomeEmpresa as Nome'), 'CNPJ', DB::raw('SUM(Valor) as Valor'))
                    ->take(1000)
                    ->orderBy('Valor', 'desc')
                    ->get();
        });

        return view('items', [
            'items' => $empresas,
            'link' => 'empresa',
            'title' => '1000 Empresas',
        ]);
    }

    public function detail($cnpj)
    {
        $cnpj = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "$1.$2.$3/$4-$5", $cnpj);
        $Empresa = PagamentosJur::where('CNPJ', $cnpj)->first();

        return view('items', [
            'items' => PagamentosJur::where('CNPJ', $cnpj)
                            ->groupBy('CNPJ','idProjeto')
                            ->select('CNPJ','idProjeto', DB::raw('SUM(Valor) as Valor'))
                            ->orderBy('Valor', 'desc')
                            ->with('projeto')
                            ->get(),
            'link' => 'projetos',
            'title' => $Empresa?$Empresa->NomeEmpresa:'Sem Descrição',
        ]);
    }

}
