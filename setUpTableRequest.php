
<?php
	require("misc.php");

	function setUpTableRequest($tableName, $nbPlayers, $password)
	{
		$arr = array('type' => "startTable", 
		"tableName" => $tableName,
		"nbPlayers" => $nbPlayers,
		"password" => $password);

		$reply = sendRequest($arr);

		return $reply;
	}
		
?>
