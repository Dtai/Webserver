<?php $tableName = htmlspecialchars($_REQUEST['name']); ?>


<html>

  <head>
    <script src="/Jquery/jquery-1.6.2.min.js" type="text/javascript"></script>
    <script src="/Highcharts/js/highcharts.js" type="text/javascript"></script>

<script type="text/javascript">

    var chartAvgP; // globally available
    var chartActions;
    var tableName;
  
    function setupGraph() {
	var xmlhttp;
	var series = new Array();
	var seriesPie = new Array();
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
	for(i=0; i<response.result.player.length; i++){
	    var player = response.result.player[i];
	//    alert(player.toSource());
	    series.push({data:[], name:player["name"]});
	}
	
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
	  text: 'Actions played'
	    },

	series: [{type: "pie", 
		 name: "Actions",
		data:[["Call", 1],
		    ["Fold", 1],
		    ["Raise", 1]]}]
});

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
	    var currPieSeries = chartActions.series[0];

	  var firstPlayer = response.result.player[0];

	    currPieSeries.setData([ ["Call", firstPlayer["nbCalls"]],
		    ["Fold", firstPlayer["nbFolds"]],
		    ["Raise", firstPlayer["nbRaises"]] ]);
	 // currPieSeries.name = firstPlayer.name;
	    
	    var i;
	    for(i=0; i< response.result.player.length; i++)
	    {
		var currPlayer = response.result.player[i];
		var currSeries = chartAvgP.series[i];
		currSeries.addPoint(response.result.player[i]["avg profit"], false);

		if(currPlayer.name != currSeries.name){
		    currSeries.name = currPlayer.name;

		    //Hack around as legend does not automatically update
		    $(currSeries.legendItem.element).text(currPlayer.name);
		    chartAvgP.legend.renderLegend();
		}
	    }
	    chartAvgP.redraw();
	}
      };
    xmlhttp.open("GET","ObserveTable.php?tableName="+tableName ,true);
    xmlhttp.send();
    }

    function observe(){
      getData();
      setTimeout('observe()',2000);
    }

    window.onload = function ()
    //function setup()
    {
      tableName = "<?php echo $tableName ?>";
      setupGraph();
      observe();
      document.getElementById("extra").innerHTML = "Hello <div id=\"world1\">world1</div> <div id=\"world2\">world2</div> <div id=\"world3\">world3</div>";
    }


</script>

</head>

<body>

<div id="avg_profit" ></div>
<div id="actions"> </div>
<div id="extra"> </div>




</body></html>
