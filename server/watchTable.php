<?php 
	require("misc.php");

	$tableName = $_REQUEST['tableName'];
    if ($tableName == '' && array_key_exists('name', $_REQUEST)) {
        $tableName = $_REQUEST['name'];
    }


    // check whether table exists
	$arr = array("type"      => "fetchData", 
	             "tableName" => $tableName);		
	
	$reply = sendRequest($arr);
	if ($reply === false) {
        show_error("Error (timeout?)", "Error connecting to server");
        exit(1);
    }

    $json = json_decode($reply, true);
    if ($json["type"] == 'error') {
        show_error($json['name'], $json['message']);
        exit(1);
    }


    $playerName = '';
    if (array_key_exists('playerName', $_REQUEST)) {
    	$playerName = $_REQUEST['playerName'];
    }
?>
<html>
	<head>
        <?php
        printf("<title>Poker table '$tableName'</title>");
		printf('<script src="%s" type="text/javascript"></script>', $lib_jquery);
		printf('<script src="%s" type="text/javascript"></script>', $lib_highcharts);
        ?>

		<script type="text/javascript">
			var chartAvgP; // globally available
			var chartActions;
			var chartPies = new Array();
			var chartRules = new Array();
			var tableName;
			var playerName;
			var refreshTime = 2000;
			var currentTime = 0;
			var windowSize = 30;

			var lastSubmits;
			var gpsText;
		  
			function setupGraph() {
				var xmlhttp;
				var series = new Array();
				if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				} else {// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.open("GET","ObserveTable.php?tableName="+tableName ,false);
				xmlhttp.send();

				var response = jQuery.parseJSON(xmlhttp.responseText);
				var i;
				var buf="";
				lastSubmits = new Array(response.result.player.length);
				for(i=0; i<response.result.player.length; i++){
					var player = response.result.player[i];
                    buf += "<div id=container_"+player["name"]+">"
					buf += "<div id=pie_"+player["name"]+" style=\"float:left; width: 49%\"> Empty: "+player["name"]+"</div> ";
					buf += "<div id=pieRules_"+player["name"]+" style=\"float:right; width: 49%\"> Empty: "+player["name"]+"</div> ";
                    buf += "<div style=\"clear: both\"></div>"
                    buf += "</div>"
					series.push({data:[], name:player["name"]});
					lastSubmits[i] = 0;
				}
				document.getElementById("extra").innerHTML = buf;
	
				chartAvgP = new Highcharts.Chart(
					{
						chart: {renderTo: 'avg_profit', type: 'line'},
						title: {text: 'Gemiddelde winst'},
						xAxis:{
							title: {text: 'Tijd'}
						},
						yAxis:{
							title: {text: 'Gemiddelde winst'}
						},
						series: series
					}
				);

				chartActions = new Highcharts.Chart(
					{
						chart: {renderTo: 'actions', type: 'pie'},
						title: {text: 'Rekentijd per speler (percentage)'},
						series: [
							{type: "pie", name: "Times", data:[]}
						],
                        plotOptions: { pie: {
                            shadow: false,
                        }}
					}
				);

				gpsText = chartAvgP.renderer.text('Spelen per second: ', 0, 20).add();

				for(i=0; i<response.result.player.length; i++){
					var player = response.result.player[i];
					tempPie = new Highcharts.Chart(
						{	
							chart: {renderTo: "pie_"+player["name"], type: 'pie'},
							title: {text: 'Acties van \''+player["name"]+'\''},
							series: [
								{type: "pie", name: "Actions", data:[["Call", 1], ["Fold", 1], ["Raise", 1]]}
							],
                            plotOptions: { pie: {
                                shadow: false,
                            }}
						}
					);
					chartPies.push(tempPie);
					
					tempPieRule = new Highcharts.Chart(
						{	
							chart: {renderTo: "pieRules_"+player["name"], type: 'pie'},
							title: {text: 'Actieve regels van \''+player["name"]+'\''},
							series: [
								{type: "pie", name: "Rules", data: [10,10,10]}
							],
                            plotOptions: { pie: {
                                shadow: false,
                            }}
						}
					);
					chartRules.push(tempPieRule);
				}
			}

			function getData(){
				var xmlhttp;
				//document.write("test0");
				if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				} else {// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
			
				xmlhttp.onreadystatechange=function() {
					if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                        // Check for ERROR
                        var errbox = document.getElementById("errorbox");
                        if (xmlhttp.responseText == "ERROR") {
                            if(errbox.style.display == 'none') {
                                errbox.innerHTML = "Error: connection with server lost, retrying...";
                                errbox.style.display = 'block';
                            }
                        } else {
                            if(errbox.style.display == 'block')
                                errbox.style.display = 'none';

                        // Handle respond
						var response = jQuery.parseJSON(xmlhttp.responseText);
						document.getElementById("parametersSmallBlind").innerHTML = "Small blind: " + response.smallBlind;
						document.getElementById("parametersBigBlind").innerHTML = "Big blind: " + response.bigBlind;
						document.getElementById("parametersMinimumRaise").innerHTML = "Minimum raise: " + response.minimumRaise;
						document.getElementById("parametersStartMoney").innerHTML = "Startgeld: " + response.startMoney;
						var gps = response.gamesPerSec;
						var timeData = new Array();

						gpsText.attr({text:'Spelen per seconde: ' + gps.toFixed(2)});
						gpsText.add();
			
						var i;
						for(i=0; i< response.result.player.length; i++) {
							var currPlayer = response.result.player[i];
							timeData.push([currPlayer.name, currPlayer["time used"]]);
							var currSeries = chartAvgP.series[i];

							if(currSeries.data.length < windowSize) {
								currSeries.addPoint([currentTime/1000,response.result.player[i]["avg profit"]], false);
							} else {
								currSeries.addPoint([currentTime/1000,response.result.player[i]["avg profit"]], false, true);
							}
						
							var currPieSeries = chartPies[i].series[0];
							currPieSeries.setData([ 
								["Call", currPlayer["nbCalls"]],
								["Fold", currPlayer["nbFolds"]],
								["Raise", currPlayer["nbRaises"]]
							]);
							
							var currPieRulesSeries = chartRules[i].series[0];
							var data = [];
							for(var j=0; j<currPlayer.rulesUsed.length; j++){
								data.push([currPlayer.rulesUsed[j].name, currPlayer.rulesUsed[j].times]);
							}
							currPieRulesSeries.setData(data);
							
							if(currPlayer.name != currSeries.name){
								currSeries.name = currPlayer.name;
				
								//Hack around as legend does not automatically update
								$(currSeries.legendItem.element).text(currPlayer.name);
								chartAvgP.legend.renderLegend();
				
								currPieSeries.name = currPlayer.name;
								currPieRulesSeries.name = currPlayer.name;
								chartPies[i].setTitle({ text: "Acties van " + currPlayer.name});
							}


							// update lastSubmit times - draw a marker if updated
							var newLastSubmit = currPlayer.lastSubmit;
							if(newLastSubmit < lastSubmits[i]) {
								chartAvgP.xAxis[0].addPlotLine(
									{value: currentTime/1000, color: 'red',	width: 2, 
										label: {text: currPlayer.name + ' submits'}
								 	}
								);
							}
							lastSubmits[i] = newLastSubmit;
						}

						chartActions.series[0].setData(timeData);
						chartAvgP.redraw();

					} // check for json ERROR (badly indented)
                    }
				};
				xmlhttp.open("GET","ObserveTable.php?tableName="+tableName ,true);
				xmlhttp.send();
			}

			function observe(){
				getData();
				currentTime = currentTime + refreshTime;
				setTimeout('observe()',refreshTime);
			}
			
			function toggle() {
				var ele = document.getElementById("extra");
				var text = document.getElementById("toggleButton");
				if(ele.style.display == "none") {
					ele.style.display = "block";
					text.innerHTML = "Verberg info spelers";
			  	} else {
					ele.style.display = "none";
					text.innerHTML = "Toon alle spelers";
				}
				
				if (ele.hasChildNodes()) {
					var children = ele.childNodes;
					for (var i = 0; i < children.length; i++) {
						if(children[i].id == "container_"+playerName){
							var pp = document.getElementById("playerPie");
							pp.appendChild(children[i]);
						}
					}
				}
			}
			
			function toggleParams() {
				var ele = document.getElementById("parameters");
				var text = document.getElementById("toggleButtonParams");
				if(ele.style.display == "none") {
					ele.style.display = "block";
					text.innerHTML = "Verberg spelparameters";
			  	} else {
					ele.style.display = "none";
					text.innerHTML = "Toon spelparameters";
				}
			} 

			window.onload = function () {
				tableName = "<?php echo htmlspecialchars($tableName) ?>";
				playerName = "<?php echo htmlspecialchars($playerName) ?>";
				
				setupGraph();
				observe();
				toggle();
			}
		</script>
		
		<style>
			.ToggleButton {
				cursor:pointer;
			}
		</style>
	</head>

	<body style="text-align:center">
        <div id="errorbox" style="display: block">
            Nog geen data ontvangen.
        </div>
		<div id="avg_profit" ></div>	
		<div id="playerPie"> </div>
		<div id="actions"> </div>
		<a class="ToggleButton" id="toggleButton" onclick="toggle()" style="float: left">Toon alle spelers</a>
		<a class="ToggleButton" id="toggleButtonParams" onclick="toggleParams()" style="float: right">Toon spelparameters</a> </br>
		<div id="parameters" style="text-align:center; display:none">
			<div id="parametersSmallBlind"></div>
			<div id="parametersBigBlind"></div>
			<div id="parametersMinimumRaise"></div>
			<div id="parametersMaximumRaise"></div>
			<div id="parametersStartMoney"></div>	
		</div>	
		<div id="extra"> </div>
	</body>
</html>
