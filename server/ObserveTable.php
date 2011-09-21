<?php 
	require("misc.php");
	$tableName = $_REQUEST['tableName'];
	$arr = array("type" => "fetchData", 
	"tableName" => $tableName);		
	
	$reply = sendRequest($arr);

	echo($reply);
?>
