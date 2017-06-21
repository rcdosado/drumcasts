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
 
    /**
     * @test
     * 
     */
    public function update_should_only_change_fillable_fields() 
    {

        $this->notSeeInDatabase('drummers', [
                'lastname' => 'peart'
            ]);

        $this->put('/drummers/1',[
                'id' => 5,
                'firstname' => 'Neil',
                'middlename' => 'Ellwood',
                'lastname' => 'Peart',
                'genre' => 'Progressive Rock'
            ]);

        $this->seeStatusCode(200)
             ->seeJson([
                    'id' => 1,
                    'firstname' => 'Neil',
                    'middlename' => 'Ellwood',
                    'lastname' => 'Peart',
                    'genre' => 'Progressive Rock'
                ])
             ->seeInDatabase('drummers',[
                    'lastname' => 'Peart'
                ]);
    }


    /**
     * @test
     * 
     */
    public function update_should_fail_with_an_invalid_id() {

      $this->put('/drummers/9999999999')
           ->seeStatusCode(404)
           ->seeJsonEquals([
                'error' => [
                    'message' => 'Drummer not found'
                ]
            ]);
    }

    /**
     * @test
     * 
     */
    public function update_should_not_match_an_invalid_route() {

        $this->put('/drummers/this-is-invalid')
             ->seeStatusCode(404);
    }

    /**
     * @test
     * 
     */
    public function destroy_should_remove_a_valid_drummer() {

        $this->delete('/drummers/1')
            ->seeStatusCode(204)
            ->isEmpty();

        $this->notSeeInDatabase('drummers', ['id'=>1]);
    }

    /**
     * @test
     * 
     */
    public function destroy_should_return_a_404_with_an_invalid_id() {

        $this->delete('/drummers/99999')
            ->seeStatusCode(404)
            ->seeJsonEquals([
                    'error' => [
                        'message' => 'Drummer not found'
                    ]
            ]);
    }

    /**
      *
      * @test
      *
      */

    public function destroy_should_not_match_an_invalid_route()
    {
            $this->delete('/drummers/this-is-invalid')
                ->seeStatusCode(404);
                
    }
      





}

