<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 28/12/2017
 * Time: 21:17.
 */

namespace Peru\Api\Service;

use Peru\Reniec\Dni;

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
     * @return array
     */
    public function get(array $dnis)
    {
        $all = [];
        foreach ($dnis as $dni) {
            $person = $this->service->get($dni);
            if ($person === false) {
                continue;
            }

            $all[] = $person;
        }

        return $all;
    }
}
