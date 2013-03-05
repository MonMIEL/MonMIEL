<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Miage
 * Date: 04/03/13
 * Time: 17:53
 * To change this template use File | Settings | File Templates.
 */
class Eolien
{
    private $max_eolien;
    private $fc_eolien;
    private $td_eolien;

    public function setMaxEolien($maxEolien){
        if(is_int($maxEolien) && $maxEolien> $this->max_eolien){
            $this->max_eolien=$maxEolien;
        }
    }

    public function getMaxEolien(){
        return $this->max_eolien;
    }
}
