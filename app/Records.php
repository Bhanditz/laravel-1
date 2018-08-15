<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Records extends Model
{
    /**
	* Specify the table name
	*
	* @var string
	*/
	protected $table = 'file';

    /**
	* The attributes that are mass assignable
	*
	* @var array
    */
    protected $fillable = ['file', 'promo_id', 'records', 'columns', 'status'];
}
