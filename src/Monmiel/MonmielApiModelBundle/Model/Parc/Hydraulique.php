<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Miage
 * Date: 04/03/13
 * Time: 17:53
 * To change this template use File | Settings | File Templates.
 */
class Hydraulique
{
    private $max_hydraulique;
    private $fc_hydraulique;
    private $td_hydraulique;

    public function setMaxHydraulique($maxHydro){
        if($maxHydro> $this->max_hydraulique){
            $this->max_hydraulique=$maxHydro;
        }
    }

    public function getMaxHydraulique(){
        return $this->max_pv;
    }
}
