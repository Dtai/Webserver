<?php 
	require("setUpTableRequest.php");
	$tableName = htmlspecialchars($_POST['name']);
	$nbPlayers = (int)$_POST['nbPlayers'];
	

	// reply error or ack message
	$reply = setUpTableRequest($tableName, $nbPlayers);
	
	echo($reply);
?>
