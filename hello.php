<?php

    //using REQUEST for debug purposes
    $classTable = htmlspecialchars($_REQUEST['tableName']);
    $playerName = htmlspecialchars($_REQUEST['playerName']);

    $arrReq = array("type" => "fetchData", 
	"tableName" => $classTable);
	
    $arrReq2 = array('request' => $arrReq);
    $message1 = json_encode($arrReq2);

    $socket1 = socket_create(AF_INET, SOCK_STREAM, 0);
    socket_connect($socket1, "borgraf", 20000);
    socket_write($socket1, $message1);
    socket_shutdown($socket1,1); 
      
    socket_recv($socket1, $reply1, 100000, MSG_WAITALL);

    $reply1JSON = json_decode($reply1, true);

    if($reply1JSON['result'] != NULL)
    {
	//Table exists
	$tableName = $playerName."_".$classTable."_test";
	$nbPlayers = 3;

	include("setUpTableRequest.php");
	// This sets up the table. If the test table already exists, nothing will happen.
	
	$ackType = "Acknowledge";
	$ackMessage = "Hello acknowledged!";
	$ackArray = array("type" => $ackType,
	    "message" => $ackMessage,
	    "testTable" => $tableName);
    }
    else 
    {
	$ackArray = array("type" => "InvalidInput",
	    "message" => "Table '".$classTable."' does not exist.");
    }

    $ackJSON = json_encode($ackArray);
    echo $ackJSON;

?>