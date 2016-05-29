<?php
$con=mysqli_connect("localhost","sensor_writer","password","TempLog"); 
 // check connection
 if (mysqli_connect_errno())
{ 
 echo "Failed to connect to MySQL: " . mysqli_connect_error(); 
}

$result = mysqli_query($con,"SELECT * FROM DS18B20 ORDER BY measure-ment_id DESC LIMIT 1");

echo "<table border='1'>".
"<h1>Temperature monitor</h1>".
"<p></p>".
"<h3>Last Reading</h3>".
"<tr>".
"<th>Temperature</th>".
"<th>Time</th>".
"</tr>";

while($row = mysqli_fetch_array($result))
{ 
echo "<tr>";
echo "<td>" . $row['value'] . "</td>";
echo "<td>". $row['time'] . "</td>";
echo "</tr>";
}
echo "</table>";

mysqli_close($con);

echo "

<html>
<head>
<script type=\"text/javascript\"
src=\"https://www.google.com/jsapi\"></script>
<script type=\"text/javascript\">
google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});
google.setOnLoadCallback(drawChart);
 function drawChart() {
 var data = google.visualization.arrayToDataTable([
 ['Time', 'Temperature'], ";

 $con=mysqli_connect("localhost","sensor_writer","password","TempLog");
// check connection
if (mysqli_connect_errno())
echo "Failed to connect to MySQL: " . mysqli_connect_error();
$result = mysqli_query($con,"SELECT * FROM DS18B20 ORDER BY measure-ment_id ASC LIMIT 1440");
while($row = mysqli_fetch_array($result))
{
echo "['" . $row['time'] . "'," .$row['value'] . "],\n";
$value = $row['value'];
}

echo "
 ['', $value ] 
 ]);
 var options = {
 title: 'Temperature logger',curveType:'function'
 };
 var chart = new
google.visualization.LineChart(document.getElementById('chart_div'));
chart.draw(data, options);
}
</script>
</head>
<body>
<div id=\"chart_div\" style=\"width: 900px; height: 500px;\"></div>
 </body>
 </html> 
 ";
