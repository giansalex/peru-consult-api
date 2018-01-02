<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 29/12/2017
 * Time: 10:53 AM.
 */

namespace Peru\Api\Service;

use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use Peru\Api\Repository\RootType;
use GraphQL\Error\FormattedError;

class GraphRunner
{
    /**
     * @var Schema
     */
    private $schema;

    /**
     * GraphRunner constructor.
     * @param RootType $queryType
     */
    public function __construct(RootType $queryType)
    {
        $this->schema = new Schema([
            'query' => $queryType,
        ]);
    }

    /**
     * @param string $query
     * @param $variables
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function execute($query, $variables)
    {
        try {
            $result = GraphQL::executeQuery($this->schema, $query, null, null, $variables);
            $output = $result->toArray();
        } catch (\Exception $e) {
            $output = [
                'errors' => [FormattedError::createFromException($e)],
            ];
        }

        return $output;
    }
}
