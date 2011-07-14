<?php 
	$arr = array('type' => "listTables");
	

	$arr2 = array('request' => $arr);
	$message = json_encode($arr2);
	//echo($message);

	$socket = socket_create(AF_INET, SOCK_STREAM, 0);
	socket_connect($socket, "borgraf", 20000);
	socket_write($socket, $message);
	socket_shutdown($socket,1); 

	// reply error or ack message
	socket_recv($socket, $reply, 100000, MSG_WAITALL);
	
	//$reply = addslashes($reply);
	echo($reply);
?>
