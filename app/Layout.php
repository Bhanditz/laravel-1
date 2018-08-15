<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class layout extends Model
{
    /**
	* Specify the table name
	*
	* @var string
	*/
	protected $table = 'layout';

    /**
	* The attributes that are mass assignable
	*
	* @var array
    */
    protected $fillable = ['promo_id', 'prize_id', 'page', 'layout', 'bg_image'];}
