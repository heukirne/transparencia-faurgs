<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ModelHelper;

class Servidor extends Model 
{

    protected $table = 'ServidoresExecutivo';
    protected $primaryKey = 'CPFcut';
    
	public function scopeLike($query, $value){
		$value = strtoupper($value);
		return $query->where('Nome', 'LIKE', "%$value%");
	}

}
