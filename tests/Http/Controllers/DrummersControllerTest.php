<?php

namespace Tests\App\Http\Controllers;

use TestCase;

class DrummersControllerTest extends TestCase
{
    /** @test **/
    public function index_status_code_should_be_200()
    {
        $this->get('/drummers')->seeStatusCode(200);
    }


    /** @test **/
    public function index_should_return_a_collection_of_records()
    {
        $this
            ->get('/drummers')
            ->seeJson([
                'firstname' => 'Mike'
            ])
            ->seeJson([
                'firstname' => 'Jacob'
            ]);

    }
    /**
     * @test
     */

    public function show_should_return_a_valid_drummer()
    {
        $this->get('/drummers/1')
            ->seeStatusCode(200)
            ->seeJson([
                'id' => 1,
                'firstname' => 'Mike',
                'middlename' => 'something',
                'lastname' => 'Portnoy',
                'genre' =>'Rock'
            ]);

        $data = json_decode($this->response->getContent(), true);
        $this->assertArrayHasKey('created_at', $data);
        $this->assertArrayHasKey('updated_at', $data);
    }

    /**
     * @test
     * 
     */
    public function show_should_fail_when_the_drummer_id_does_not_exist() {

        $this->get('/drummers/99999')
            ->seeStatusCode(404)
            ->seeJson([
                'error' => [
                    'message' => 'Drummer not found'
                ]
            ]);
    }

    /**
     * @test
     * 
     */
    public function show_route_should_not_match_an_invalid_route() {

        $this->get('/drummers/this-is-invalid');
        $this->assertNotRegExp(
            '/Drummer not found/',
            $this->response->getContent(),
            'DrummersController@show route matching when it should not.'
        );  
    }


    /**
     *
     * @test
     *
     */

    public function store_should_save_new_drummer_in_the_database()
    {
        $this->post('/drummers',[
                'firstname' => 'Chris',
                'middlename' => 'Caballero',   
                'lastname' => 'Cole',
                'genre' => 'electronica'
            ]);
           

            $this->seeJson(['created'=>true])
                 ->seeInDatabase('drummers', [
                        'lastname' => 'Cole'
            ]);
    }

    /**
     *
     * @test
     *
     */
    
    public function store_should_respond_with_a_201_and_location_header_when_successful()
    {
        $this->post('/drummers',[
                'firstname' => 'Mike',
                'middlename' => 'Finch',   
                'lastname' => 'Portnoy',
                'genre' => 'Progressive'
            ]);

        $this->seeStatusCode(201)
            ->seeHeaderWithRegExp('Location', '#/drummers/[\d]+$#');
            
    }



}




    


