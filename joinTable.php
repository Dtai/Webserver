<?php 
	$arr = array('type' => "joinTable", 
	"tableName" => htmlspecialchars($_POST['tableName']),
	"id" => (int)$_POST['index'],
	"playerName" => htmlspecialchars($_POST['playerName']),
	"description" => htmlspecialchars($_POST['descr'])
	);
	

	$arr2 = array('request' => $arr);
	$message = json_encode($arr2);
	echo($message);

	$socket = socket_create(AF_INET, SOCK_STREAM, 0);
	socket_connect($socket, "joske", 20000);
	socket_write($socket, $message);
	socket_shutdown($socket,1); 
?>
