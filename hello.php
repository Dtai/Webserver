<?php

    $classTable = htmlspecialchars($_POST['tableName']);
    $playerName = htmlspecialchars($_POST['playerName']);
    $tableName = $playerName."_test";
    $nbPlayers = 3;

    include("setUpTableRequest.php");
    
?>