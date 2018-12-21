<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{	
	//Campos de nuestra tabla que podran ser insertados.
    protected $fillable = ['id_tab', 'text', 'order', 'check'];
}
