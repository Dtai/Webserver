<?php

// Configuration options
$PokerbotServer = "localhost";

// watchTable.php uses JQuery and Highcharts javascript libraries
$lib_DIR = "/pokerdemo";
$lib_jquery = "$lib_DIR/Jquery/jquery-1.6.2.min.js";
$lib_highcharts = "$lib_DIR/Highcharts/js/highcharts.js";


// function to connect to the backend server
function sendRequest($array)
{
    global $PokerbotServer;

    $arrReq = array('request' => $array);
    $message = json_encode($arrReq);

    $socket = socket_create(AF_INET, SOCK_STREAM, 0);
    socket_connect($socket, $PokerbotServer, 20000);
    socket_write($socket, $message);
    socket_shutdown($socket,1); 
      
    socket_recv($socket, $reply, 100000, MSG_WAITALL);

    return $reply;
}

?>
