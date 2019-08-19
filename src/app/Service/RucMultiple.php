<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 28/12/2017
 * Time: 21:17.
 */

declare(strict_types=1);

namespace Peru\Api\Service;

use Peru\Services\RucInterface;

class RucMultiple
{
    /**
     * @var RucInterface
     */
    private $service;

    /**
     * RucMultiple constructor.
     *
     * @param RucInterface $service
     */
    public function __construct(RucInterface $service)
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
            if (!$company) {
                continue;
            }

            $all[] = $company;
        }

        return $all;
    }
}
