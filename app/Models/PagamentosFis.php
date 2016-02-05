<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ModelHelper;

class PagamentosFis extends Model 
{

    protected $table = 'faurgsPagamentosPF';

    public function projeto()
    {
        return $this->belongsTo('App\Models\Projetos', 'idProjeto', 'id');
    }

    public function getTotalAttribute($value)
    {
		return ModelHelper::realCurrency($value);
    }

    public function getValorAttribute($value)
    {
		return ModelHelper::realCurrency($value);
    }

    public function getDataAttribute($value)
    {
        return ModelHelper::brDate($value);
    }

    public function CPFLink()
    {
        return preg_replace('/[^\d]/', '', $this->attributes['CPF']);
    }

}
