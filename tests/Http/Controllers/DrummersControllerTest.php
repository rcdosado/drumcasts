<?php

namespace Tests\App\Http\Controllers;

use TestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;

class DrummersControllerTest extends TestCase
{

    use DatabaseMigrations;

    /** @test **/
    public function index_status_code_should_be_200()
    {
        $this->get('/drummers')->seeStatusCode(200);
    }


    /** @test **/
    public function index_should_return_a_collection_of_records()
    {

        $drummers = factory('App\Drummer', 2)->create();

        $this->get('/drummers');
        
        foreach ($drummers as $drummer) {
            $this->seeJson(['firstname' => $drummer->firstname]);
            $this->seeJson(['middlename' => $drummer->middlename]);
            $this->seeJson(['lastname' => $drummer->lastname]);
            $this->seeJson(['genre' => $drummer->genre]);
        }

    }
    /**
     * @test
     */

    public function show_should_return_a_valid_drummer()
    {

        $drummer = factory('App\Drummer')->create();
        $this->get("/drummers/{$drummer->id}")
             ->seeStatusCode(200)
             ->seeJson([
                    'id' => $drummer->id,
                    'firstname' => $drummer->firstname,
                    'middlename' => $drummer->middlename,
                    'lastname' => $drummer->lastname,
                    'genre' => $drummer->genre
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

        $drummer = factory('App\Drummer')->create([
                'firstname' => 'Raimund',
                'middlename' => 'Tayag',
                'lastname' => 'Mrasigan',
                'genre' => 'pop'
            ]);
        $this->put("/drummers/{$drummer->id}",[
                'id' => 5,
                'firstname' => 'Raimund',
                'middlename' => 'Gadot',
                'lastname' => 'Marasigan',
                'genre' => 'punk rock'
            ]);
            
        $this->seeStatusCode(200)
             ->seeJson([
                'id' => 1 ,
                'firstname' => 'Raimund',
                'middlename' => 'Gadot',
                'lastname' => 'Marasigan',
                'genre' => 'punk rock'
            ])
            ->seeInDatabase('drummers',[
                 'genre' => 'punk rock'
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
        
        $drummer = factory('App\Drummer')->create();
        $this->delete("/drummers/{$drummer->id}")
             ->seeStatusCode(204)
             ->isEmpty();

        $this->notSeeInDatabase('drummers',['id' => $drummer->id]);
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

