<?php


function sendRequest($array)
{

    $arrReq = array('request' => $array);
    $message = json_encode($arrReq);

    $socket = socket_create(AF_INET, SOCK_STREAM, 0);
    socket_connect($socket, "borgraf", 20000);
    //socket_connect($socket1, "joske", 20000);
    socket_write($socket, $message);
    socket_shutdown($socket,1); 
      
    socket_recv($socket, $reply, 100000, MSG_WAITALL);

    return $reply;
}

?>
