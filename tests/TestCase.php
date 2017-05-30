<?php

class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }


    /**
     *
     * See if the response has a header. 
     *
     * @param $header
     * @return $this
     */

    public function seeHasHeader($header)
    {
    	$this->assertTrue($this->response->headers->has($header),
    		"Response should have the header '{$header}' but does not.");

    	return $this;
    		
    }
    
    /**
     *
     * Asserts the the response header matches a given regular expression
     * @param $header
     * @param $regexp
     * @param $this
     *
     */

    public function seeHeaderWithRegExp($header, $regexp)
    {
    	$this->seeHasHeader($header)
    		 ->assertRegExp(
	    		 	$regexp, 
	    		 	$this->response->headers->get($header)
    		 	);

    	return $this;
    }
    

}




