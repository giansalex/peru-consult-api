<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 29/12/2017
 * Time: 10:53 AM.
 */

declare(strict_types=1);

namespace App\Service;

use GraphQL\Executor\ExecutionResult;
use GraphQL\Executor\Promise\Adapter\ReactPromiseAdapter;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use React\Promise\Promise;
use React\Promise\PromiseInterface;

class GraphRunner
{
    /**
     * @var ReactPromiseAdapter
     */
    private $adapter;
    /**
     * @var Schema
     */
    private $schema;

    /**
     * GraphRunner constructor.
     * @param ReactPromiseAdapter $adapter
     * @param Schema $schema
     */
    public function __construct(ReactPromiseAdapter $adapter, Schema $schema)
    {
        $this->adapter = $adapter;
        $this->schema = $schema;
    }

    /**
     * @param string $query
     * @param $variables
     *
     * @return PromiseInterface
     */
    public function execute($query, $variables)
    {
        $graphPromise = GraphQL::promiseToExecute($this->adapter,$this->schema, $query, null, null, $variables);

        $resolver = function (callable $resolve) use ($graphPromise) {

            $graphPromise->then(function (ExecutionResult $result) use ($resolve) {
                $resolve($result->toArray());
            });
        };

        return new Promise($resolver);
    }
}
