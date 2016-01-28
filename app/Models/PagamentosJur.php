<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ModelHelper;

class PagamentosJur extends Model 
{

    protected $table = 'faurgsPagamentosPJ';

    public function projeto()
    {
        return $this->belongsTo('App\Models\Projetos', 'idProjeto', 'id');
    }

    public function getCNPJAttribute($value)
    {
        return preg_replace('/[^\d]/', '', $value);
    }

    public function getTotalAttribute($value)
    {
		return ModelHelper::realCurrency($value);
    }

   public function getValorAttribute($value)
    {
		return ModelHelper::realCurrency($value);
    }

}
