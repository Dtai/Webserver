<?php
	require("misc.php");
	$classTable = $_REQUEST['tableName'];
	$playerName = $_REQUEST['playerName'];

	$arr = array('type' => "leaveTable", 
	"tableName" => $classTable,
	"playerName" => $playerName
	);

	$reply = sendRequest($arr);

    /**
     * We no longer create testtables
     * Should somebody wish to re-active this,
     * then make the test-table in the client!
	$testTableName = $playerName."_".$classTable."_test";
	$arr2 = array("type" => "killTestTable", "tableName" => $testTableName);
	$reply2 = sendRequest($arr2);
    */

	echo($reply);
?>
