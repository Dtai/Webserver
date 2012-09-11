<?php 
	require("misc.php");
	$tableName = $_REQUEST['tableName'];
	$arr = array("type" => "fetchData", 
	"tableName" => $tableName);		
	
	$reply = sendRequest($arr, 2, true);

	if ($reply === false)
        $reply = "ERROR";
	
    echo $reply;
?>
