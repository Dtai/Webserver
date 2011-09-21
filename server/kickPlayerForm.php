<html>
	<head>
		<title> Kick speler </title>
		<link href="style.css" type="text/css" rel="stylesheet"/>
	</head>

	<body>
		<div class="input">
			<form action="kickPlayer.php" method="post">
			    <fieldset class="main">
			        <legend>Kick speler</legend>                        

			        <fieldset class="nested">
				        <legend>Gegevens</legend>    
				        <ol>
							<li>
								<label for="tableName">Naam tafel</label>
								<input id="tableName" name="tableName" type="text"/>
							</li>
							<li>
								<label for="playerName">Naam speler</label>
								<input id="playerName" name="playerName" type="text"/>
							</li>
							<li>
								<label for="password">Wachtwoord</label>
								<input id="password" name="password" type="password"/>
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
