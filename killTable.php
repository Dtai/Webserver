<?php 
	require("misc.php");

	$tableName = $_POST['tableName'];
	$arr = array("type" => "killTable", 
	"tableName" => $tableName);
	
	$reply = sendRequest($arr);
	echo($reply);
?>
