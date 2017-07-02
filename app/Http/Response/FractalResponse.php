<?php

namespace App\Http\Response;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\ResourceInterface;

class FractalResponse 
{
    /**
     * @var Manager
     *
     */
    private $manager; 

    /**
     * @var SerializerAbstract
     */

    public function __construct(Manager $manager, SerializerAbstract $serializer)
    {
        $this->manager = $manager;
        $this->serializer = $serializer;
        $this->manager->setSerializer($serializer);
    }

    /**
     * item function
     *
     * @return array of resource
     */
    public function item($data, TransformerAbstract $transformer, $resourceKey = null)
    {
        return $this->createDataArray(
            new Item($data, $transformer, $resourceKey)
        );
    }
    /**
     * collection method
     *
     * @return $array
     */
    public function collection($data, TransformerAbstract $transformer, $resourceKey=null)
    {
        return $this->createDataArray(
            new Collection($data, $transformer, $resourceKey)
        );
    }

    /**
     * produce Data Array
     *
     * @return $array
     */
    private function createDataArray(ResourceInterface $resource)
    {
        return $this->manager->createData($resource)->toArray();
    }
    
    
}

