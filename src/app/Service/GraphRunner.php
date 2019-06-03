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
use Psr\Log\LoggerInterface;

class GraphRunner
{
    /**
     * @var Schema
     */
    private $schema;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * GraphRunner constructor.
     * @param RootType $queryType
     * @param LoggerInterface $logger
     */
    public function __construct(RootType $queryType, LoggerInterface $logger)
    {
        $this->schema = new Schema([
            'query' => $queryType,
        ]);
        $this->logger = $logger;
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
            var_dump($e);
            $this->logger->error($e->getMessage());
            $output = [
                'errors' => [FormattedError::createFromException($e)],
            ];
        }

        return $output;
    }
}
