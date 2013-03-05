<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;
/**
 * Created by JetBrains PhpStorm.
 * User: Miage
 * Date: 04/03/13
 * Time: 17:54
 * To change this template use File | Settings | File Templates.
 */
class Autres
{
    private $max_autre;

    private $fc_autre;

    private $td_autre;

    public function setMaxAutre($maxAutre){
        if($maxAutre> $this->max_autre){
            $this->max_autre=$maxAutre;
        }
    }

    public function getMaxAutre(){
        return $this->max_autre;
    }
}
