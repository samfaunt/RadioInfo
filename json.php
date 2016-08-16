<?php
/**
 * Created by PhpStorm.
 * User: samfaunt
 * Date: 11/08/2016
 * Time: 10:06 PM
 */

function stations($ip, $username, $password) {

    $fields = [
        'username' => $username,
        'password' => $password,
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, sprintf('https://%s/login.cgi', $ip));
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_exec($ch); // Login

    curl_setopt($ch, CURLOPT_HTTPGET, 1);
    curl_setopt($ch, CURLOPT_URL, sprintf('https://%s/sta.cgi', $ip));

    $stations = curl_exec($ch); // Get Statons

    curl_close($ch);

    return json_decode($stations);

}

function sizeFilter( $bytes )
{
    $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
    for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
    return( round( $bytes, 2 ));
}
function clientInfo($ipaddress,$username,$password)
{
    $clients = stations($ipaddress, $username, $password);

    foreach ($clients as $i => $client) {
        $clientname = $clients[$i]->remote->hostname;
        $signal = $clients[$i]->remote->signal;
        $devicetype = $clients[$i]->remote->platform;
        $firmware = $clients[$i]->remote->version;
        $uplinkcapacity = $clients[$i]->airmax->uplink_capacity;
        $uplinkcapacity = sizeFilter($uplinkcapacity);
        $downlinkcapacity = $clients[$i]->airmax->downlink_capacity;
        $downlinkcapacity = sizeFilter($downlinkcapacity);

        $apclients[$i] = array
        (
            array($clientname, $signal, $devicetype, $firmware, $uplinkcapacity, $downlinkcapacity)

        );

        return $apclients;
    }


}

