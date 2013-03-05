<?php

namespace Monmiel\MonmielApiModelBundle\Event;

use JMS\Serializer\EventDispatcher\Event;
use JMS\DiExtraBundle\Annotation as DI;

class NewDayEvent extends Event
{
    /**
     * @var \Monmiel\MonmielApiModelBundle\Model\Day
     */
    protected $day;

    /**
     * @param \JMS\Serializer\VisitorInterface $day
     */
    function __construct($day)
    {
        $this->day = $day;
    }

    /**
     * @return \JMS\Serializer\VisitorInterface|\Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function getDay()
    {
        return $this->day;
    }
}
