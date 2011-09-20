<html>
	<head>
		<title>Verwijder tafel</title>
		<link rel="stylesheet" href="bootstrap.css">
		<style>
			div#message {
				width: 50%;
				margin: auto;
			}
		</style>
	</head>
	
	<body>
		<div id="message">
			<?php 
				require("misc.php");
				$tableName = $_POST['tableName'];
				$arr = array("type" => "killTable", "tableName" => $tableName);
				$reply = sendRequest($arr);
	
				$json = json_decode($reply, true);
				if($json["type"] == "Acknowledge"){
					echo '<div class="alert-message block-message success">';
						echo '<p>Message: ' . $json["message"] . '</p>';

						echo '<div class="alert-actions">';
							echo '<a class="btn small" href="index.php">Hoofdpagina</a>';
						echo '</div>';
				  	echo '</div>';
				} else {
					echo '<div class="alert-message block-message error">';
						echo '<p><strong>Error: ' . $json["name"] . '</p>';
						echo '<p>Message: ' . $json["message"] . '</p>';

						echo '<div class="alert-actions">';
							echo '<a class="btn small" href="killTableForm.php">Terug</a>';
							echo '<a class="btn small" href="index.php">Hoofdpagina</a>';
						echo '</div>';
				  	echo '</div>';
				}
			?>
		</div>
	</body>
</html>
