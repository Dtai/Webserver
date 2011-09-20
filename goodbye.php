<?php
	require("misc.php");

	$arr = array('type' => "leaveTable", 
	"tableName" => $_REQUEST['tableName'],
	"playerName" => $_REQUEST['playerName']
	);

	$reply = sendRequest($arr);
	echo($reply);
?>
