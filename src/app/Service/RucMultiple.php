<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 28/12/2017
 * Time: 21:17.
 */

declare(strict_types=1);

namespace Peru\Api\Service;

use Peru\Sunat\Ruc;

class RucMultiple
{
    /**
     * @var Ruc
     */
    private $service;

    /**
     * RucMultiple constructor.
     *
     * @param Ruc $service
     */
    public function __construct(Ruc $service)
    {
        $this->service = $service;
    }

    /**
     * @param array $rucs
     *
     * @return array
     */
    public function get(array $rucs)
    {
        $all = [];
        foreach ($rucs as $ruc) {
            $company = $this->service->get($ruc);
            if ($company === false) {
                continue;
            }

            $all[] = $company;
        }

        return $all;
    }
}
