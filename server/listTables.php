<html>
	<head>
		<title>Tafels</title>
		<link rel="stylesheet" href="bootstrap.css">
		<style>
			div#message{
				width: 50%;
				margin: auto;
			}
			div#tableName{
				/*width: 10%;
				margin: auto;*/
				text-align: center;
				font-weight: bold;
			}
			div#left{
				float: left;
			}
			div#right{
				float: right;
			}
			div#clear{
				clear: both;
			}
		</style>
	</head>
	
	<body>
		<div id="message">
			<?php 
				require("misc.php");
				$arr = array('type' => "listTables");
				$reply = sendRequest($arr);
				$json = json_decode($reply, true);
				$tables = $json["tables"];
				
				foreach($tables as $table){
					echo '<div class="alert-message block-message info">';
						echo '<div id="tableName">';
							echo $table["name"];
						echo '</div>';
						echo '<p>';
							echo '<div id="left"> Aantal spelers: ' . $table["nbPlayers"] . '</div>';
							if($table["running"]){
								echo '<div id="right"> Actief </div>';
							} else {
								echo '<div id="right"> Inactief </div>';
							}
							echo '<div id="clear"></div>';
						echo '</p>';
				  	echo '</div>';
				}
				echo '<a class="btn small" href="index.php">Hoofdpagina</a>';
			?>
		</div>
	</body>
</html>
