<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    /**
	* Specify the table name
	*
	* @var string
	*/
	protected $table = 'prize';

    /**
	* The attributes that are mass assignable
	*
	* @var array
    */
    protected $fillable = ['prize', 'description', 'image', 'quantity', 'promo_id', 'prize_order'];
}
