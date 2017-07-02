<?php
 namespace Tests\App\Transformer;

 use TestCase;
 use App\Drummer;
 use App\Transformer\DrummerTransformer;
 use League\Fractal\TransformerAbstract;
 use Laravel\Lumen\Testing\DatabaseMigrations;

class DrummerTransformerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test **/
    public function it_can_be_initialized()
    {
        $genre = new DrummerTransformer();
        $this->assertInstanceOf(TransformerAbstract::class, $genre);
    }
    /** @test **/
    public function it_transforms_a_drummer_model()
    {
        $drummer = factory(Drummer::class)->create();
        $drumtransformer = new DrummerTransformer();
        $transform = $drumtransformer->transform($drummer);

        $this->assertArrayHasKey('id', $transform);
        $this->assertArrayHasKey('firstname', $transform);
        $this->assertArrayHasKey('lastname', $transform);
        $this->assertArrayHasKey('middlename', $transform);
        $this->assertArrayHasKey('genre', $transform);
        // $this->assertArrayHasKey('published', $transform);

    }
}
