<?php 
	$arr = array('type' => "fetchData", 
	"tableName" => htmlspecialchars($_POST['tableName']),
	);
	

	$arr2 = array('request' => $arr);
	$message = json_encode($arr2);
	echo($message);
	echo("\n");

	$socket = socket_create(AF_INET, SOCK_STREAM, 0);
	socket_connect($socket, "joske", 20000);
	socket_write($socket, $message);
	socket_shutdown($socket,1); 

	socket_recv($socket, $reply, 1000, MSG_WAITALL);

	echo($reply);
?>
