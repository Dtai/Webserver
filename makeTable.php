<?php 
	$arr = array('type' => "startTable", 
	"tableName" => htmlspecialchars($_POST['name']),
	"nbPlayers" => (int)$_POST['nbPlayers']);

	$arr2 = array('request' => $arr);
	$message = json_encode($arr2);
	echo($message);

	$socket = socket_create(AF_INET, SOCK_STREAM, 0);
	socket_connect($socket, "joske", 20000);
	socket_write($socket, $message);
	socket_shutdown($socket,1); 
?>
