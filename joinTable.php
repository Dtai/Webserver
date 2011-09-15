<?php 
	require("misc.php");

	$arr = array('type' => "joinTable", 
	"tableName" => $_POST['tableName'],
	"playerName" => $_POST['playerName'],
	"description" => $_POST['description']
	);
	

	$reply = sendRequest($arr);
	
	echo($reply);
?>
