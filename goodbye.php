<?php
	require("misc.php");
	$classTable = $_REQUEST['tableName'];
	$playerName = $_REQUEST['playerName'];

	$arr = array('type' => "leaveTable", 
	"tableName" => $classTable,
	"playerName" => $playerName
	);

	$reply = sendRequest($arr);

	$testTableName = $playerName."_".$classTable."_test";
	$arr2 = array("type" => "killTestTable", "tableName" => $testTableName);
	$reply2 = sendRequest($arr2);

	echo($reply);
?>
