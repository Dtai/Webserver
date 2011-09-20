<html>
	<head>
		<title> Maak tafel </title>
		<link href="style.css" type="text/css" rel="stylesheet"/>
	</head>

	<body>
		<div class="input">
			<form action="makeTable.php" method="post">
			    <fieldset class="main">
			        <legend>Maak tafel</legend>                        

			        <fieldset class="nested">
				        <legend>Gegevens</legend>    
				        <ol>
							<li>
								<label for="name">Naam tafel</label>
								<input id="name" name="name" type="text"/>
							</li>
							<li>
								<label for="nbPlayers">Aantal spelers</label>
								<input id="nbPlayers" name="nbPlayers" type="text"/>
							</li>
							<li>
								<label for="password">Wachtwoord</label>
								<input id="password" name="password" type="text"/>
							</li>
				        </ol>
			        </fieldset>

					<a id="button" href="index.php">Hoofdpagina</a>
			        <div class="buttonsContainer">
		                <input class="button" type="submit" value="Voer in" />
			        </div>
			    </fieldset>
			</form>
		</div>
	</body>
</html>
