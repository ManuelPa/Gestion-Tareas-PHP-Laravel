<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tab extends Model
{	
	//Campos de nuestra tabla que podran ser insertados.
    protected $fillable = ['id_user', 'name', 'color', 'order', 'grid_wide', 'grid_height'];
}
