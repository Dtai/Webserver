<html>
	<head>
		<title> Maak tafel </title>
		<link href="style.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript">
			function validateForm(){
				var e = document.getElementById("password");
				if(e.value.length == 0){
					alert("Wachtwoord is te kort");
					return false;
				}
				return true;
			}
		</script>
	</head>

	<body>
		<div class="input">
			<form action="makeTable.php" method="post" onsubmit="return validateForm()">
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
								<input id="password" name="password" type="text"/><br />
							</li>
                            <li>
                                <i>Wachtwoord enkel nodig voor beheer zoals spelers verwijderen</i>
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
