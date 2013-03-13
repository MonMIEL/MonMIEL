<?php

namespace Monmiel\MonmielApiBundle\Dao;

interface DaoInterface
{
    /**
     * @param $key string
     */
    public function get($key);

    /**
     * @param $day \Monmiel\MonmielApiModelBundle\Model\Day
     * @return mixed bool
     */
    public function put($day);
}
