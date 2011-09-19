<?php $tableName = $_REQUEST['name']; ?>


<html>

  <head>
    <script src="/Jquery/jquery-1.6.2.min.js" type="text/javascript"></script>
    <script src="/Highcharts/js/highcharts.js" type="text/javascript"></script>

<script type="text/javascript">

    var chartAvgP; // globally available
    var chartActions;
    var chartPies = new Array();
    var tableName;
    var refreshTime = 2000;
    var currentTime = 0;
    var windowSize = 30;

    var lastSubmits;
    var gpsText;
  
    function setupGraph() {
	var xmlhttp;
	var series = new Array();
	var seriesPie = new Array();
	var seriesPiePlayers = new Array();
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.open("GET","ObserveTable.php?tableName="+tableName ,false);
	xmlhttp.send();

	var response = jQuery.parseJSON(xmlhttp.responseText);
	//alert(response.result.player[0].toSource());
	//alert(response.result.player[0].nbFolds);
	var i;
	var buf="";
	lastSubmits = new Array(response.result.player.length);
	for(i=0; i<response.result.player.length; i++){
	    var player = response.result.player[i];
	    buf += "<div id=pie_"+player["name"]+"> Empty: "+player["name"]+"</div> ";
	//    alert(player.toSource());
	    series.push({data:[], name:player["name"]});

	    lastSubmits[i] = 0;
	}
        document.getElementById("extra").innerHTML = buf;
	
	chartAvgP = new Highcharts.Chart({
	
	chart: {
	  renderTo: 'avg_profit',
	  type: 'line'
	    },
	title: {
	  text: 'Average profit'
	    },

	xAxis:{
	  title: {
	    text: 'Time'
	    }
	  },

	yAxis:{
	  title: {
	    text: 'Average profit'
	    }
	  },

	series: series
	});

	chartActions = new Highcharts.Chart({
	
	chart: {
	  renderTo: 'actions',
	  type: 'pie'
	    },
	title: {
	  text: 'Time used'
	    },

	series: [{type: "pie", 
		 name: "Times",
		data:[]}]
});

	gpsText = chartAvgP.renderer.text('Games per second: ', 0, 20).add();


	for(i=0; i<response.result.player.length; i++){
	    var player = response.result.player[i];

	tempPie = new Highcharts.Chart({
	
	chart: {
	  renderTo: 'pie_'+player["name"],
	  type: 'pie'
	    },
	title: {
	  text: 'Actions of player \''+player["name"]+'\''
	    },

	series: [{type: "pie", 
		 name: "Actions",
		data:[["Call", 1],
		    ["Fold", 1],
		    ["Raise", 1]]}]
});
    	    chartPies.push(tempPie);
	}

    }

    function getData(){
    var xmlhttp;
    //document.write("test0");
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
	    var response = jQuery.parseJSON(xmlhttp.responseText);
	    var gps = response.gamesPerSec;
	    var timeData = new Array();

	    gpsText.attr({text:'Games per second: ' + gps.toFixed(2)});
	    gpsText.add();
	    
	    var i;
	    for(i=0; i< response.result.player.length; i++)
	    {


		var currPlayer = response.result.player[i];
		timeData.push([currPlayer.name, currPlayer["time used"]]);
		
		var currSeries = chartAvgP.series[i];

		if(currSeries.data.length < windowSize)
		{
			currSeries.addPoint([currentTime/1000,response.result.player[i]["avg profit"]], false);
		}
		else
		{
			currSeries.addPoint([currentTime/1000,response.result.player[i]["avg profit"]], false, true);
		}

		
	      var currPieSeries = chartPies[i].series[0];


	      currPieSeries.setData([ ["Call", currPlayer["nbCalls"]],
		    ["Fold", currPlayer["nbFolds"]],
		    ["Raise", currPlayer["nbRaises"]] ]);
	    

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
              if(newLastSubmit < lastSubmits[i])
	      	{
                    chartAvgP.xAxis[0].addPlotLine({
			value: currentTime/1000,
			color: 'red',
			width: 2,
			label: {
				text: currPlayer.name + ' submits'}
			 });
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

    window.onload = function ()
    //function setup()
    {
      tableName = "<?php echo htmlspecialchars($tableName) ?>";
      setupGraph();
      observe();
    }


</script>

</head>

<body>

<div id="avg_profit" ></div>
<div id="actions"> </div>
<div id="extra"> </div>




</body></html>
