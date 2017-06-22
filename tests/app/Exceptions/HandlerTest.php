<?php 

namespace Tests\App\Exceptions;

use TestCase;
use \Mockery as m;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Handler Test
 */
class HandlerTest extends TestCase
{

	/** @test **/
	public function it_responds_with_html_when_json_is_not_accepted()
	{
		// make the mock a partial, you only want to mock the `isDebugMode` method
		$subject = m::mock(Handler::class)->makePartial();
		$subject->shouldNotReceive('isDebugMode');
		
		// Mock the interaction with the Request
		$request = m::mock(Request::class);
		$request->shouldReceive('wantsJson')->andReturn(false);
		
		// Mock the interaction with the exception
		$exception = m::mock(\Exception::class, ['Error!']);
		$exception->shouldNotReceive('getStatusCode');
		$exception->shouldNotReceive('getTrace');
		$exception->shouldNotReceive('getMessage');

		// Call the method under test, this is not a mocked method.
		$result = $subject->render($request, $exception);
		
		// Assert that `render` does not requren a JsonResponse
		$this->assertNotInstanceOf(JsonResponse::class, $result);
	}	
}


