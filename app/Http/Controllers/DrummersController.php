<?php
namespace App\Http\Controllers;

use App\Drummer;
use Illuminate\Http\Request;
use App\Transformer\DrummerTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DrummersController extends Controller
{


	/**
	* GET / drummers
	* @return array
	*
	*/

	public function index()
	{
        return $this->collection(Drummer::all(), new DrummerTransformer());
	}


	/**
	 * GET /drummers/{id}
	 * @param int $id
	 * @return mixed
	 */
    public function show(int $id) 
    {
        return $this->item(Drummer::findOrFail($id), new DrummerTransformer);
	}

	/**
	 * store
	 * POST /drummers
	 * @param Request $request
  	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function store(Request $request) 
    {
        $drummer = Drummer::create($request->all());
        $data = $this->item($drummer, new DrummerTransformer());
        return response()->json($data, 201, [
            'Location' => route('drummers.show', ['id' => $drummer->id])
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

        return $this->item($drummer, new DrummerTransformer());
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



//page 65

