<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Miage
 * Date: 04/03/13
 * Time: 17:05
 * To change this template use File | Settings | File Templates.
 */
require_once('Nucleaire.php');
require_once('Eolien.php');
require_once('Hydraulique.php');
require_once('Pv.php');
require_once('Autres.php');



class Parc{

    private $nucleaire;
    private $eolien;
    private $pv;
    private $hydraulique;
    private $autres;

    public function __construct(){
        $this->nucleaire= new Nucleaire();
        $this->eolien= new Eolien();
        $this->pv=new Pv();
        $this->hydraulique=new Hydraulique();
        $this->autres=new Autres();
    }

    //Méthode permettant de vérifier si les valeurs en paramètre sont les max
    public function setMaxValue($valeurNucleaire, $valeurEolien, $valeurPv, $valeurHydraulique, $valeurAutre){
        $this->nucleaire->setMaxNucleaire($valeurNucleaire);
        $this->eolien->setMaxEolien($valeurEolien);
        $this->pv->setMaxPv($valeurPv);
        $this->hydraulique->setMaxHydraulique($valeurHydraulique);
        $this->autres->setMaxAutre($valeurAutre);
    }

}
$parc= new Parc();
$parc->setMaxNucleaire('5');
echo $parc->getMaxNucleaire();

