<?php

$stationnamesnmp = snmpwalk("10.106.8.1", "public", ".1.3.6.1.4.1.41112.1.4.7.1.2");
$signalsnmp = snmpwalk("10.106.8.1", "public", ".1.3.6.1.4.1.41112.1.4.7.1.3");
$stationmacsnmp = snmpwalk("10.106.8.1","public",".1.3.6.1.4.1.41112.1.4.7.1.1");
$stationTxRate = snmpwalk("10.106.8.1", "public",".1.3.6.1.4.1.41112.1.4.7.1.17");



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

foreach ($stationmacsnmp as $value){
    $str = $value;
    if (strpos($str, '"') !== false ){
        $str = substr($str, 9, -1);
        $str = bin2hex($str);
        $str = chunk_split($str,2,' ');
        $str = strtoupper($str);
        $stationmac[] = $str;


        //echo 'true';
    }else {
        $str = substr($str,12);
        $stationmac[] = $str;
    }


    //echo $str. "\n";


}

//var_dump($stationmacsnmp);


/*foreach ($signal as $key => $value) {
	echo  $stationname[$key] .  " // Signal:" . $signal[$key] . " // "." Mac Address: " . $stationmac[$key] ."\n";
}*/

var_dump($stationTxRate);



//var_dump($signal);

//var_dump($stationname);


//var_dump($signalsnmp);

//var_dump($stationname);
