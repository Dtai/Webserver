<?php 
	$arr = array('type' => "joinTable", 
	"tableName" => htmlspecialchars($_POST['tableName']),
	"playerName" => htmlspecialchars($_POST['playerName']),
	"description" => htmlspecialchars($_POST['descr'])
	);
	

	$arr2 = array('request' => $arr);
	$message = json_encode($arr2);
	//echo($message);

	$socket = socket_create(AF_INET, SOCK_STREAM, 0);
	socket_connect($socket, "borgraf", 20000);
	socket_write($socket, $message);
	socket_shutdown($socket,1); 

	// reply error or ack message
	socket_recv($socket, $reply, 1000, MSG_WAITALL);
	
	$reply = addslashes($reply);
	echo($reply);
?>
