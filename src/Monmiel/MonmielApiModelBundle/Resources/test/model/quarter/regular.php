<?php

use Monmiel\MonmielApiModelBundle\Model\Quarter;

//$timezone = new DateTimeZone('Europe/Paris');
$date = date_create_from_format("Y-m-d H:i:s", "2011-01-01 00:00:00");
$object = new Quarter($date, 5050, 5050, 5050, 5050, 5050, 5050, 5050, 5050);
