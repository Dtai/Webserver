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
                    $name = $table["name"];
					echo '<div class="alert-message block-message info">';
						echo '<div id="tableName">Tafel: ';
							echo $name;
						echo '</div>';
						echo '<p>';
							echo '<div id="left"> Aantal spelers: ';
                            printf('<a href="watchTable.php?tableName=%s">%s', $name, $table["nbPlayers"]);
							if($table["running"]){
								echo ' (Actief)';
							} else {
								echo ' (Inactief)';
							}
                            echo '</a></div>';
                            printf('<div id="right">
                                        <a href="stopTableForm.php?name=%s">Pauzeer</a>
                                      - <a href="resumeTableForm.php?name=%s">Hervat</a>
                                      - <a href="kickPlayerForm.php?name=%s">Kick speler</a>
                                      - <a href="killTableForm.php?name=%s">Verwijder</a></div>
                                   ', $name, $name, $name, $name);
							echo '<div id="clear"></div>';
						echo '</p>';
				  	echo '</div>';
				}
				echo '<a class="btn small" href="index.php">Hoofdpagina</a>';
			?>
		</div>
	</body>
</html>
