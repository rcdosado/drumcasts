<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

/*
* 
*
*/
class Drummer extends Model
{


	/**
	 * The attributes that are mass assignable
	 * @var datatype
	 */

	protected $fillable = ['firstname', 'middlename','lastname','genre'];

}


