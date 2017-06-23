<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 *  to fill database with new records 
 *  run phpunit test 
 *  then `php artisan migrate`
 *  then `php artisan db:seed`
*/
class DrummersTableSeeder extends Seeder
{
	/**
	* Run the database seeds.
	* @return void
	*/
	public	function run()
	{
        $drummers = factory('App\Drummer', 25)->create();
	}
}
