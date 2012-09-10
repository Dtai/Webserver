<?php

// Configuration options
$PokerbotServer = "localhost";

// watchTable.php uses JQuery and Highcharts javascript libraries
$lib_DIR = "/pokerdemo";
$lib_jquery = "$lib_DIR/Jquery/jquery-1.6.2.min.js";
$lib_highcharts = "$lib_DIR/Highcharts/js/highcharts.js";


// function to connect to the backend server
// returns the result
// OR boolean 'false' on failure (e.g. timeout)
function sendRequest($array, $timeout=5)
{
    global $PokerbotServer;

    $arrReq = array('request' => $array);
    $message = json_encode($arrReq);

    $socket = socket_create(AF_INET, SOCK_STREAM, 0);
    if ($socket === false) {
        echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
    }

    // set timeouts
    socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec"=>$timeout, "usec"=>0));
    socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array("sec"=>$timeout, "usec"=>0));
 
    $ret = socket_connect($socket, $PokerbotServer, 20000);
    if ($ret === false) {
        echo "socket_connect() failed.\nReason: " . socket_strerror(socket_last_error($socket)) . "\n";
    }

    $ret = socket_write($socket, $message, strlen($message));
    // shutdown socket for writing (is this to force a flush?)
    socket_shutdown($socket,1); 
      
    $ret = socket_recv($socket, $reply, 100000, MSG_WAITALL);
    socket_close($socket);
    
    if ($ret === false) {
	if (socket_last_error($socket) == '') {
	    echo "socket: timeout reached\n";
        } else {
            echo "socket_recv() failed.\nReason: " . socket_strerror(socket_last_error($socket)) . "\n";
        }
        return false;
    }

    return $reply;
}


// show an error (assumes nothing is written before/after this)
function show_error($name, $message)
{
?>
<html>
	<head>
		<title>Error</title>
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
		    <div class="alert-message block-message error">
                <p><strong>Error: <?php echo $name ?> </p>
				<p>Message: <?php echo $message ?> </p>

				<div class="alert-actions">
				    <a class="btn small" href="index.php">Hoofdpagina</a>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
}

?>
