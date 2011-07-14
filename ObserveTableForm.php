<html><body>

<script type="text/javascript">

var xmlhttp;

function init()
{
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }

	 xmlhttp.onreadystatechange = show();
}

function show()
{
	//  document.write("in show function");
	//  document.write(xmlhttp.readyState);
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    alert(xmlhttp.responseText);
	//    document.write("\n\n On response in javascript");
	    }
	//  document.write("upon exiting show function");
}

function getData(tableName)
{
	//document.write(tableName);
	xmlhttp.open("GET","ObserveTable.php?tableName=ww5" ,true);

	//document.write("after open");
	xmlhttp.send();
	//document.write("On exiting getData method");
}

function observeTable()
{
	init();
	//document.write("boo");
	//var tableName = document.getElementbyId('tableName');
	getData("ww5");
	//setTimeout('alert(\'hello\')',2000);
	//setTimeout('observeTable()',500);
	//document.write("back in observeTable");
}

</script>


<form>
	<p> Naam van de tafel: <input type="text" name="tableName" /> </p>
	<p><input type ="button" onclick="observeTable()" value ="Volg tafel"/> </p>
</form>

</body>


</html>
