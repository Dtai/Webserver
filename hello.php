<?php

    $classTable = htmlspecialchars($_POST['tableName']);
    $playerName = htmlspecialchars($_POST['playerName']);

    $arrReq = array("type" => "fetchData", 
	"tableName" => $classTable);
	
    $arrReq2 = array('request' => $arrReq);
    $message1 = json_encode($arrReq2);

    $socket1 = socket_create(AF_INET, SOCK_STREAM, 0);
    socket_connect($socket1, "borgraf", 20000);
    socket_write($socket1, $message1);
    socket_shutdown($socket1,1); 
      
    socket_recv($socket1, $reply1, 1000, MSG_WAITALL);

    $reply1JSON = json_decode($reply1, true);

    if($reply1JSON['result'] != NULL)
    {
	$tableName = $playerName."_".$classTable."_test";
	$nbPlayers = 3;

	include("setUpTableRequest.php");
	
	$ackType = "Acknowledge";
	$ackMessage = "Hello acknowledged!";
	$ackArray = array("type" => $ackType,
	    "message" => $ackMessage);
    }
    else 
    {
	$ackArray = array("type" => "InvalidInput",
	    "message" => "Table does not exist.");
    }

    $ackJSON = json_encode($ackArray);
    echo $ackJSON;

?>