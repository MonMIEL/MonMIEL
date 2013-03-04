<?php

namespace Monmiel\MonmielApiModelBundle\Model;

class Quarter
{
    /**
     * @var integer
     */
    protected $consoTotal;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var integer
     */
    protected $fuel;

    /**
     * @var integer
     */
    protected $charbon;

    protected $gaz;

    protected $nucleaire;

    protected $eolien;

    protected $hydraulique;

    protected $photovoltaique;

    protected $autre;

    protected $solde;


}
