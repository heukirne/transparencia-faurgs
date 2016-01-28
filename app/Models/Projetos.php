<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ModelHelper;
use DateTime;

class Projetos extends Model 
{

    protected $table = 'faurgsProjetos';

    public function getNomeAttribute($value)
    {
        $dateIni = DateTime::createFromFormat("Y-m-d", $this->attributes['DataInicio']);
        $dateFim = DateTime::createFromFormat("Y-m-d", $this->attributes['DataFim']);
    	return ModelHelper::removeAccent($value) .' ('. $dateIni->format("Y") .'-'. $dateFim->format("Y") .')';
    }

    public function getObjetoAttribute($value)
    {
    	return ModelHelper::removeAccent($value);
    }

    public function getUnidadeExecutoraAttribute($value)
    {
    	return ModelHelper::removeAccent($value);
    }

    public function getOrgaoFinanciadorAttribute($value)
    {
        return ModelHelper::removeAccent($value);
    }

    public function getContratoConvenioAttribute($value)
    {
        return ModelHelper::removeAccent($value);
    }

    public function getValorAttribute($value)
    {
		return ModelHelper::realCurrency($value);
    }
    
    public function getDataInicioAttribute($value)
    {
        return ModelHelper::brDate($value);
    }

    public function getDataFimAttribute($value)
    {
        return ModelHelper::brDate($value);
    }

}
