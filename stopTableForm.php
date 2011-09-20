<html>
	<head>
		<title>Stop tafel</title>
		<link href="style.css" type="text/css" rel="stylesheet"/>
	</head>

	<body>
		<div class="input">
			<form action="stopTable.php" method="post">
			    <fieldset class="main">
			        <legend>Stop tafel</legend>                        

			        <fieldset class="nested">
				        <legend>Gegevens</legend>    
				        <ol>
							<li>
								<label for="tableName">Naam tafel</label>
								<input id="tableName" name="tableName" type="text"/>
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
