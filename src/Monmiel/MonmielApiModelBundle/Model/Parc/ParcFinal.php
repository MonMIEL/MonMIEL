<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;
/**
 * Created by JetBrains PhpStorm.
 * User: Miage
 * Date: 05/03/13
 * Time: 17:49
 * To change this template use File | Settings | File Templates.
 */
class ParcFinal
{
    private $nucleaire;
    private $eolien;
    private $pv;
    private $hydraulique;
    private $autres;

    public function __construct( $nucleaire, $eolien, $pv, $hydraulique, $autres){
        $this->nucleaire= $nucleaire;
        $this->eolien= $eolien;
        $this->pv= $pv;
        $this->hydraulique=$hydraulique;
        $this->autres= $autres;
    }

    public function getNucleaire(){
        return $this->nucleaire;
    }

    public function getEolien(){
        return $this->eolien;
    }

    public function getPv(){
        return $this->pv;
    }

    public function getHydraulique(){
        return $this->hydraulique;
    }

    public function getAutre(){
        return $this->autres;
    }
}
