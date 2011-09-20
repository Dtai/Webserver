<?php
	require("misc.php");

	$arr = array('type' => "kickPlayer", 
	"tableName" => $_REQUEST['tableName'],
	"playerName" => $_REQUEST['playerName'],
	"password" => $_REQUEST['password']
	);

	$reply = sendRequest($arr);
	echo($reply);
?>
