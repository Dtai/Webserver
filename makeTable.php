<?php 
	$tableName = htmlspecialchars($_POST['name']);
	$nbPlayers = (int)$_POST['nbPlayers'];
	
	include("setUpTableRequest.php");

	// reply error or ack message
	socket_recv($socket, $reply, 100000, MSG_WAITALL);
	
	//$reply = addslashes($reply);
	echo($reply);
?>