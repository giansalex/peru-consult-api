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
use React\Promise\PromiseInterface;
use function React\Promise\all;

class DniMultiple
{
    /**
     * @var Dni
     */
    private $service;

    /**
     * DniMultiple constructor.
     *
     * @param Dni $service
     */
    public function __construct(Dni $service)
    {
        $this->service = $service;
    }

    /**
     * @param array $dnis
     *
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
