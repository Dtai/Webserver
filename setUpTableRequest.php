
<?php
	require("misc.php");

	function setUpTableRequest($tableName, $nbPlayers)
	{
		$arr = array('type' => "startTable", 
		"tableName" => $tableName,
		"nbPlayers" => $nbPlayers);

		$reply = sendRequest($arr);

		return $reply;
	}
		
?>
