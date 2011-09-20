<html>
	<head>
		<title>Maak tafel</title>
		<link rel="stylesheet" href="http://twitter.github.com/bootstrap/1.3.0/bootstrap.min.css">
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
				require("setUpTableRequest.php");
				$tableName = $_POST['name'];
				$nbPlayers = (int)$_POST['nbPlayers'];
	

				// reply error or ack message
				$reply = setUpTableRequest($tableName, $nbPlayers);
	
				$json = json_decode($reply, true);
				if($json["type"] == "error"){
					echo '<div class="alert-message block-message warning">';
						echo '<p><strong>Error: ' . $json["name"] . '</p>';
						echo '<p>Message: ' . $json["message"] . '</p>';

						echo '<div class="alert-actions">';
							echo '<a class="btn small" href="makeTableForm.php">Terug</a>';
						echo '</div>';
				  	echo '</div>';
				} else {
			
				}
			?>
		</div>
	</body>
</html>
