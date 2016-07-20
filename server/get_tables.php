<?php 
	require("misc.php");
	$arr = array('type' => "listTables");
	$reply = sendRequest($arr, 2);
	//$json = json_decode($reply, true);
	//$tables = $json["tables"];
    echo $reply;
?>
