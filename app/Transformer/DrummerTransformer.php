<?php 
namespace App\Transformer;

use League\Fractal\TransformerAbstract;

class DrummerTransformer extends TransformerAbstract
{

    /** @test **/
    public function it_can_be_initialized()
    {
        $genre = new DrummerTransformer();

        $this->assertInstanceOf(TransformerAbstract::class, $genre);
    }
}


?>
