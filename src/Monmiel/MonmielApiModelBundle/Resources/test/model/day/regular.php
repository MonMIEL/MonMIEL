<?php

use Monmiel\MonmielApiModelBundle\Model\Day;
use Monmiel\MonmielApiModelBundle\Model\Quarter;

$date1 = date_create_from_format("Y-m-d H:i:s", "2011-01-01 00:00:00");
$date2 = date_create_from_format("Y-m-d H:i:s", "2011-01-01 00:15:00");
$object = new Day($date1);

$q1 = new Quarter($date1, 5050, 5050, 5050, 5050, 5050, 0, 5050, 5050);
$q2 = new Quarter($date2, 5050, 5050, 5050, 5050, 5050, 0, 5050, 5050);

$object->addQuarters($q1);
$object->addQuarters($q2);