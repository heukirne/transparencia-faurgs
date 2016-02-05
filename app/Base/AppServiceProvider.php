<?php

namespace App\Base;

use Cache;
use App\Models\PagamentosFis;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
 
    public function boot()
    {

		$first = Cache::remember('first', 600, function() {
            return PagamentosFis::select('Data')
                        ->orderBy('Data', 'asc')
                        ->first();
        });

		$last = Cache::remember('last', 600, function() {
            return PagamentosFis::select('Data')
                        ->orderBy('Data', 'desc')
                        ->first();
        });

        view()->share('dataini', $first->Data);
        view()->share('datafim', $last->Data);
    }

    public function register()
    {
    	//
    }

}