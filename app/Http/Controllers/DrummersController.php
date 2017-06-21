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


	/**
	 *
	 * @update
	 * PUT /drummers
	 * @param Request $request
	 * return mixed
	 *
	 */
	public function update(Request $request, $id)
	{

		try {

			$drummer = Drummer::findOrFail($id);
			
		} catch (ModelNotFoundException $e) {
			return response()->json([
					'error' => [
						'message' => 'Drummer not found'
					]
				], 404);
		}
		$drummer->fill($request->all());
		$drummer->save();

		return $drummer;
	}

	/**
	 *
	 * DELETE /drummers/{id}
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 *
	 */
	
	
	public function destroy($id)
	{
			try 
			{
				$drummer = Drummer::findOrFail($id);
			} 
			catch (	ModelNotFoundException $e) 
			{
				return response()->json([
					'error' => ['message' => 'Drummer not found']
				 ], 404);
			}//catch

			$drummer->delete();

			return response(null, 204);
	}


	





}







