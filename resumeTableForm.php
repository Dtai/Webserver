<html>
	<head>
		<title>Hervat tafel</title>
		<link href="style.css" type="text/css" rel="stylesheet"/>
	</head>

	<body>
		<div class="input">
			<form action="resumeTable.php" method="post">
			    <fieldset class="main">
			        <legend>Hervat tafel</legend>                        

			        <fieldset class="nested">
				        <legend>Gegevens</legend>    
				        <ol>
							<li>
								<label for="tableName">Naam tafel</label>
								<input id="tableName" name="tableName" type="text"/>
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
