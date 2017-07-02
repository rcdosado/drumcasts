<?php

namespace Tests\App\Http\Controllers;

use TestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Carbon\Carbon;

class DrummersControllerTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * run this first for every test
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::now('UTC'));

    }

    /**
     * run after test method is run
     *
     * @return void
     */
    public function tearDown()
    {
        Carbon::setTestNow();
    }
    
    

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
        $content = json_decode( $this->response->getContent(),true );
        $this->assertArrayHasKey('data', $content);

        foreach ($drummers as $drummer) {
            $this->seeJson([
                    'id' => $drummer->id,
                    'firstname' => $drummer->firstname,
                    'middlename' => $drummer->middlename,
                    'lastname' => $drummer->lastname,
                    'genre' => $drummer->genre,
                    'created' => $drummer->created_at->toIso8601String(),
                    'updated' => $drummer->updated_at->toIso8601String(),
            ]);
        }
    }
    /**
     * @test
     */

    public function show_should_return_a_valid_drummer()
    {

        $drummer = factory('App\Drummer')->create();
        $expected = [
            'data' => $drummer->toArray()
        ];
        $this->get("/drummers/{$drummer->id}")
            ->seeStatusCode(200);
        $content = json_decode( $this->response->getContent(), true );
        $this->assertArrayHasKey('data', $content);
        $data = $content['data'];

        $this->assertEquals($drummer->id, $data['id']);
        $this->assertEquals($drummer->firstname, $data['firstname']);
        $this->assertEquals($drummer->middlename, $data['middlename']);
        $this->assertEquals($drummer->lastname, $data['lastname']);
        $this->assertEquals($drummer->genre, $data['genre']);
    }

    /**
     * @test
     * 
     */
    public function show_should_fail_when_the_drummer_id_does_not_exist() {

        $this->get('/drummers/99999', ['Accept' => 'application/json'])
            ->seeStatusCode(404)
            ->seeJson([
                'error' => [
                    'message' => 'Not Found',
                    'status' => 404
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
        $body = json_decode( $this->response->getContent(),true );
        $this->assertArrayHasKey('data', $body);

        $data = $body['data'];
        $this->assertEquals('Chris', $data['firstname']);
        $this->assertEquals('Caballero', $data['middlename']);
        $this->assertEquals('Cole', $data['lastname']);
        $this->assertEquals('electronica', $data['genre']);

        $this->assertTrue($data['id']>0,'Expected a positive integer,but did not see one.');
        $this->assertArrayHasKey('created', $data);
        $this->assertEquals(Carbon::now()->toIso8601String(),$data['created']);
        $this->assertArrayHasKey('updated', $data);
        $this->assertEquals(Carbon::now()->toIso8601String(), $data['updated']);
        $this->seeInDatabase('drummers', [ 'lastname' => 'Cole' ]);
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
        $body = json_decode( $this->response->getContent(), true );
            
        $this->seeStatusCode(200)
             ->seeJson([
                'id' => 6 ,
                'firstname' => 'Raimund',
                'middlename' => 'Gadot',
                'lastname' => 'Marasigan',
                'genre' => 'punk rock'
            ])
            ->seeInDatabase('drummers',[
                 'genre' => 'punk rock'
            ]);

        $body = json_decode( $this->response->getContent(), true );
        $this->assertArrayHasKey('data', $body);

        $data = $body['data'];
        $this->assertArrayHasKey('created', $data);
        $this->assertEquals(Carbon::now()->toIso8601String(), $data['created']);
        $this->assertArrayHasKey('updated', $data);
        $this->assertEquals(Carbon::now()->toIso8601String(),$data['updated']);
    }


    /**
     * @test
     * 
     */
    public function update_should_fail_with_an_invalid_id() {

      $this->put('/drummers/9999999')
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

