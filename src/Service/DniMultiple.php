<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 28/12/2017
 * Time: 21:17.
 */

declare(strict_types=1);

namespace App\Service;

use Peru\Jne\Async\Dni;
use function React\Promise\all;
use React\Promise\PromiseInterface;

class DniMultiple
{
    /**
     * @var Dni
     */
    private $service;

    /**
     * DniMultiple constructor.
     */
    public function __construct(Dni $service)
    {
        $this->service = $service;
    }

    /**
     * @return PromiseInterface
     */
    public function get(array $dnis): PromiseInterface
    {
        $all = [];
        foreach ($dnis as $dni) {
            $promise = $this->service->get($dni);

            $all[] = $promise;
        }

        return all($all);
    }
}
