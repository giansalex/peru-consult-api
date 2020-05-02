<?php

namespace App\Factory;

use App\Types\RootType;
use GraphQL\Type\Schema;

class GraphqlSchemaFactory
{
    /**
     * @var RootType
     */
    private $root;

    /**
     * GraphqlSchemaFactory constructor.
     */
    public function __construct(RootType $root)
    {
        $this->root = $root;
    }

    public function create()
    {
        return new Schema([
            'query' => $this->root,
        ]);
    }
}
