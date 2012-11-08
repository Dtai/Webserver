<?php 
	require("misc.php");

	$arr = array('type' => "joinTable", 
	"tableName" => $_REQUEST['tableName'],
	"playerName" => $_REQUEST['playerName'],
	"description" => $_REQUEST['description']
	);
	

	$reply = sendRequest($arr);
	
	echo($reply);
?>
