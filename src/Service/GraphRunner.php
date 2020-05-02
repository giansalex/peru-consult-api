<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 29/12/2017
 * Time: 10:53 AM.
 */

declare(strict_types=1);

namespace App\Service;

use GraphQL\Error\FormattedError;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
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
     */
    public function __construct(Schema $schema, LoggerInterface $logger)
    {
        $this->schema = $schema;
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
