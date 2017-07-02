<?php 
namespace App\Transformer;

use App\Drummer;
use League\Fractal\TransformerAbstract;

class DrummerTransformer extends TransformerAbstract
{
    /**
     * Transform a Drummer model into an array
     *
     * @param Drummer $drummer 
     * @return array
     */
    public function transform(Drummer $drummer)
    {
        return [
            'id' => $drummer->id,
            'firstname' => $drummer->firstname,
            'middlename' => $drummer->middlename,
            'lastname' => $drummer->lastname,
            'genre' => $drummer->genre,
            'created' => $drummer->created_at->toIso8601String(),
            'updated' => $drummer->updated_at->toIso8601String()
            // 'published' => $drummer->created_at->diffForHumans()

        ];
    }

}


?>
