
<?php
	$arr = array('type' => "startTable", 
	"tableName" => $tableName,
	"nbPlayers" => $nbPlayers);

	$arr2 = array('request' => $arr);
	$message = json_encode($arr2);
	//echo($message);

	$socket = socket_create(AF_INET, SOCK_STREAM, 0);
	socket_connect($socket, "borgraf", 20000);
	socket_write($socket, $message);
	socket_shutdown($socket,1); 
?>