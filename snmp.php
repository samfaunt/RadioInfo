<?php

$stationnamesnmp = snmpwalk("10.106.8.1", "public", ".1.3.6.1.4.1.41112.1.4.7.1.2");
$signalsnmp = snmpwalk("10.106.8.1", "public", ".1.3.6.1.4.1.41112.1.4.7.1.3");


foreach ($signalsnmp as $value) {
	$str = (string) $value;
	$str = substr($str, 8);
	$signal[] = $str;
}

foreach ($stationnamesnmp as $value) {
	$str = (string) $value;
	$str = substr($str, 7);
	$str = substr($str, 2,-1);
	$stationname[] = $str;
}


foreach ($signal as $key => $value) {
	echo  $stationname[$key] .  " - Signal:" . $signal[$key] . "\n";
}





//var_dump($signal);

//var_dump($stationname);


//var_dump($signalsnmp);

//var_dump($stationname);
