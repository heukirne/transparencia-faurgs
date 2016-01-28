<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ModelHelper;

class Orgaos extends Model 
{

    protected $table = 'faurgsOrgaos';
    
    public function getNomeAttribute($value)
    {
    	return ModelHelper::removeAccent($value);
    }

    public function getValorAttribute($value)
    {
		return ModelHelper::realCurrency($value);
    }

}
