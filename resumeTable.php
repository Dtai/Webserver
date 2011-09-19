<?php 
	require("misc.php");
	//REQUEST for debug purposes, should later replace with POST
	$tableName = $_POST['tableName'];
	$arr = array("type" => "resumeTable", 
	"tableName" => $tableName);

	$reply = sendRequest($arr);
	
	echo($reply);
?>
