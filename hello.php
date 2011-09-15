<?php


   // require("misc.php");
    require("setUpTableRequest.php");

    //using REQUEST for debug purposes
    $classTable = $_REQUEST['tableName'];
    $playerName = $_REQUEST['playerName'];

    $arrReq = array("type" => "fetchData", 
	"tableName" => $classTable);

    $reply1 = sendRequest($arrReq);

    $reply1JSON = json_decode($reply1, true);

    if($reply1JSON['result'] != NULL)
    {
	//Table exists
	$tableName = $playerName."_".$classTable."_test";
	$nbPlayers = 3;

	// This sets up the test table. If the test table already exists, nothing will happen.
	setUpTableRequest($tableName, $nbPlayers);
	
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
