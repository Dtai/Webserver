<?php 
	$tableName = $_REQUEST['name'];
	$playerName = $_REQUEST['playerName'];
?>
<html>
	<head>
		<script src="/Jquery/jquery-1.6.2.min.js" type="text/javascript"></script>
		<script src="/Highcharts/js/highcharts.js" type="text/javascript"></script>

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
				var rules="";
				lastSubmits = new Array(response.result.player.length);
				for(i=0; i<response.result.player.length; i++){
					var player = response.result.player[i];
					buf += "<div id=pie_"+player["name"]+"> Empty: "+player["name"]+"</div> ";
					rules += "<div id=pieRules_"+player["name"]+"> Empty: "+player["name"]+"</div> ";
					series.push({data:[], name:player["name"]});
					lastSubmits[i] = 0;
				}
				document.getElementById("extra").innerHTML = buf;
				document.getElementById("rules").innerHTML = rules;
	
				chartAvgP = new Highcharts.Chart(
					{
						chart: {renderTo: 'avg_profit', type: 'line'},
						title: {text: 'Average profit'},
						xAxis:{
							title: {text: 'Time'}
						},
						yAxis:{
							title: {text: 'Average profit'}
						},
						series: series
					}
				);

				chartActions = new Highcharts.Chart(
					{
						chart: {renderTo: 'actions', type: 'pie'},
						title: {text: 'Time used'},
						series: [
							{type: "pie", name: "Times", data:[]}
						]
					}
				);

				gpsText = chartAvgP.renderer.text('Games per second: ', 0, 20).add();

				for(i=0; i<response.result.player.length; i++){
					var player = response.result.player[i];
					tempPie = new Highcharts.Chart(
						{	
							chart: {renderTo: "pie_"+player["name"], type: 'pie'},
							title: {text: 'Actions of player \''+player["name"]+'\''},
							series: [
								{type: "pie", name: "Actions", data:[["Call", 1], ["Fold", 1], ["Raise", 1]]}
							]
						}
					);
					chartPies.push(tempPie);
					
					tempPieRule = new Highcharts.Chart(
						{	
							chart: {renderTo: "pieRules_"+player["name"], type: 'pie'},
							title: {text: 'Rules of player \''+player["name"]+'\''},
							series: [
								{type: "pie", name: "Rules", data:[["Call", 1], ["Fold", 1], ["Raise", 1]]}
							]
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
						var response = jQuery.parseJSON(xmlhttp.responseText);
						document.getElementById("parametersSmallBlind").innerHTML = "Small blind: " + response.smallBlind;
						document.getElementById("parametersBigBlind").innerHTML = "Big blind: " + response.bigBlind;
						document.getElementById("parametersMinimumRaise").innerHTML = "Minimum raise: " + response.minimumRaise;
						document.getElementById("parametersStartMoney").innerHTML = "Start money: " + response.startMoney;
						var gps = response.gamesPerSec;
						var timeData = new Array();

						gpsText.attr({text:'Games per second: ' + gps.toFixed(2)});
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
							currPieRulesSeries.setData([ 
								["Call", currPlayer["nbCalls"]],
								["Fold", currPlayer["nbFolds"]],
								["Raise", currPlayer["nbRaises"]]
							]);

							if(currPlayer.name != currSeries.name){
								currSeries.name = currPlayer.name;
				
								//Hack around as legend does not automatically update
								$(currSeries.legendItem.element).text(currPlayer.name);
								chartAvgP.legend.renderLegend();
				
								currPieSeries.name = currPlayer.name;
								chartPies[i].setTitle({ text: "Actions of player " + currPlayer.name});
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
					text.innerHTML = "hide";
			  	} else {
					ele.style.display = "none";
					text.innerHTML = "show";
				}
				
				if (ele.hasChildNodes()) {
					var children = ele.childNodes;
					for (var i = 0; i < children.length; i++) {
						if(children[i].id == "pie_"+playerName){
							var c = children[i];
							var pp = document.getElementById("playerPie");
							pp.appendChild(c);
						}
					}
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
			a#toggleButton {
				cursor:pointer;
			}
		</style>
	</head>

	<body style="text-align:center">
		<div id="avg_profit" ></div>
		<div id="parameters" style="text-align:center">
			<div id="parametersSmallBlind"></div>
			<div id="parametersBigBlind"></div>
			<div id="parametersMinimumRaise"></div>
			<div id="parametersMaximumRaise"></div>
			<div id="parametersStartMoney"></div>	
		</div>		
		<div id="actions"> </div>
		<a id="toggleButton" onclick="toggle()">hide</a>
		<div id="playerPie"> </div>
		<div id="extra"> </div>
		<div id="rules"> </div>
	</body>
</html>
