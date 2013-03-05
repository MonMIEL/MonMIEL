<?php

namespace Monmiel\MonmielApiModelBundle\Model;


class Jour_DAO
{

    /**
     * @var \DateTime
     */
    protected $jour;

    /**
     * @var array<\Monmiel\MonmielApiModelBundle\Model\Quarter>
     */
    protected $quarters;



    function __construct($jour, $quarters)
    {
        $this->jour = $jour;
        $this->quarters = $quarters;
    }

    /**
     * @param \DateTime $jour
     */
    public function setJour($jour)
    {
        $this->jour = $jour;
    }

    /**
     * @param array $quarters
     */
    public function setQuarters($quarters)
    {
        $this->quarters = $quarters;
    }

    /**
     * @return \DateTime
     */
    public function getJour()
    {
        return $this->jour;
    }

    /**
     * @return array
     */
    public function getQuarters()
    {
        return $this->quarters;
    }



}
