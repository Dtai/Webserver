<html><body>


<?php
	$arr = array('type' => "fetchData", 
	"tableName" => $_POST['tableName'],
	);
	

	$arr2 = array('request' => $arr);
	$message = json_encode($arr2);
	echo($message);
	echo("\n");

	$socket = socket_create(AF_INET, SOCK_STREAM, 0);
	socket_connect($socket, "borgraf", 20000);
	socket_write($socket, $message);
	socket_shutdown($socket,1); 

	socket_recv($socket, $reply, 1000, MSG_WAITALL);

	$reply = addslashes($reply);
	echo($reply);

?>

<script language="javascript" type="text/javascript">

document.write("something\n");

var reply = "<?php echo $reply; ?>";
document.write("something else");
document.write(reply);
alert(reply);
 </script>

</body></html>
