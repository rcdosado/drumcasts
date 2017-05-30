<?php


namespace App\Http\Controllers;



use Illuminate\Database\Eloquent\ModelNotFoundException;


use App\Drummer;
use Illuminate\Http\Request;



class DrummersController
{


	/**
	* GET / drummers
	* @return array
	*
	*/

	public function index()
	{
		return Drummer::all();
	}


	/**
	 * GET /drummers/{id}
	 * @param int $id
	 * @return mixed
	 */
	public function show(int $id) {

		try {
			return Drummer::findOrFail($id);
		} catch (ModelNotFoundException $e) {
			
			return response()->json([
					'error' => [
						'message' => 'Drummer not found'
					]
				], 404);
		}
	}

	/**
	 * store
	 * POST /drummers
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function store(Request $request) {

		$drummer = Drummer::create($request->all());	
		return response()->json(['created' => true], 201, [
				'Location' => route('drummers.show', ['id'=>$drummer->id])
		]);
	}





}









