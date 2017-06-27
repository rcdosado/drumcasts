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
}
