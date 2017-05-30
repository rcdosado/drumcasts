<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
* 
*/
class DrummersTableSeeder extends Seeder
{
	/**
	* Run the database seeds.
	* @return void
	*/
	public	function run()
	{
	
		DB::table('drummers')->insert([
			'firstname' => 'Mike',
			'middlename' => 'something',
			'lastname' => 'Portnoy',
			'genre' => 'Rock',
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now()
		]);
		DB::table('drummers')->insert([
			'firstname' => 'Jacob',
			'middlename' => 'something',
			'lastname' => 'Bacaltos',
			'genre' => 'Rock',
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now()
		]);


	}
}