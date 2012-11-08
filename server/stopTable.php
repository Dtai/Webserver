<html>
	<head>
		<title>Stop tafel</title>
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
				$arr = array("type" => "stopTable", "tableName" => $tableName, "password" => $_POST["password"]);

				$reply = sendRequest($arr);
	
				$json = json_decode($reply, true);
				if($json["type"] == "Acknowledge"){
					echo '<div class="alert-message block-message success">';
						echo '<p>Message: ' . $json["message"] . '</p>';

						echo '<div class="alert-actions">';
						
							echo '<form action="watchTable.php" method="post" style="float:right">';
								echo '<input id="name" name="tableName" type="hidden" value="' . $tableName . '"/>';
				            	echo '<input class="btn small" type="submit" value="Toon tafel" />';
							echo '</form>';
						
							echo '<a class="btn small" href="index.php">Hoofdpagina</a>';
				  	echo '</div>';
				} else {
					echo '<div class="alert-message block-message error">';
						echo '<p><strong>Error: ' . $json["name"] . '</p>';
						echo '<p>Message: ' . $json["message"] . '</p>';

						echo '<div class="alert-actions">';
							echo '<a class="btn small" href="stopTableForm.php">Terug</a>';
							echo '<a class="btn small" href="index.php">Hoofdpagina</a>';
						echo '</div>';
				  	echo '</div>';
				}
			?>
		</div>
	</body>
</html>
