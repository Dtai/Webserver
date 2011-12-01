
<html>
	<head>
		<title> Pokerbotserver </title>
		<link href="style.css" type="text/css" rel="stylesheet"/>
	</head>
	
	<body>
		<h1>De Pokerbot tafels beheren</h1>
		
		 <div class="input">			
			<a class="Metrobutton cyan" href="makeTableForm.php">Nieuwe tafel</a>
			<a class="Metrobutton green" href="ObserveTableForm.php">Toon tafel</a>
			<a class="Metrobutton pink" href="listTables.php">Toon alle tafels</a>
		 </div>
         <p>&nbsp;</p>
		 <div class="input">			
            <h3>Tafelbeheer (wachtwoord nodig)</h3>
			<a class="Metrobutton" href="stopTableForm.php">Pauzeer tafel</a>
			<a class="Metrobutton yellow" href="resumeTableForm.php">Hervat tafel</a>
			<a class="Metrobutton blue" href="kickPlayerForm.php">Kick speler van tafel</a>
			<a class="Metrobutton red" href="killTableForm.php">Verwijder tafel</a>
		 </div>

<?php 
    if (array_key_exists('debug', $_GET)) {
         ?>
         <p>&nbsp;</p>
         <div class="input">
            <h3>Debugging:</h3>
			<a class="Metrobutton" href="joinTableForm.php">Spelen op een tafel</a>
        </div>
        <?php
    }
?>
<p>
Terug naar de <a href="../">hoofdpagina</a>.
</p>
	</body>
</html>
