<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 28/12/2017
 * Time: 21:17.
 */

declare(strict_types=1);

namespace Peru\Api\Service;

use Peru\Services\DniInterface;

class DniMultiple
{
    /**
     * @var DniInterface
     */
    private $service;

    /**
     * DniMultiple constructor.
     *
     * @param DniInterface $service
     */
    public function __construct(DniInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param array $dnis
     *
     * @return array
     */
    public function get(array $dnis)
    {
        $all = [];
        foreach ($dnis as $dni) {
            $person = $this->service->get($dni);
            if (!$person) {
                continue;
            }

            $all[] = $person;
        }

        return $all;
    }
}
