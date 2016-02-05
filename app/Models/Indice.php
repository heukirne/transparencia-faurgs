<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indice extends Model 
{

    protected $table = 'faurgsIndex';
    
	public function scopeLike($query, $value){
		$value = strtoupper($value);
		$query->orwhere('Nome', 'LIKE', "%$value%");
		$query->orWhereRaw("match (Nome) against (? IN NATURAL LANGUAGE MODE)", [$value]);
		return $query;
	}

}
