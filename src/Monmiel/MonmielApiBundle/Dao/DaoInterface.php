<?php

namespace Monmiel\MonmielApiBundle\Dao;

interface DaoInterface
{
    /**
     * @param $day integer Le xiéme jour de 2011
     */
    public function getDayConso($day);
}
