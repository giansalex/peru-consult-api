<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 28/12/2017
 * Time: 21:25.
 */

namespace Peru\Api\Service;

class ArrayConverter
{
    /**
     * @param mixed $value
     *
     * @return array
     */
    public function convert($value)
    {
        if (is_array($value)) {
            $arr = [];
            foreach ($value as $item) {
                $arr[] = get_object_vars($item);
            }

            return $arr;
        }

        return get_object_vars($value);
    }
}
