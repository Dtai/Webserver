<?php 
	require("misc.php");
	$arr = array('type' => "listTables");
	
	$reply = sendRequest($arr);

	echo($reply);
?>
