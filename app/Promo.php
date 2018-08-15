<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
	/**
	* Specify the table name
	*
	* @var string
	*/
	protected $table = 'promo';

    /**
	* The attributes that are mass assignable
	*
	* @var array
    */
    protected $fillable = ['promo', 'mechanics', 'start_date', 'end_date', 'raffle_date', 'status'];
}
