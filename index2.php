    <html>
    <head><title>Current Temperature & Pressure</title></head>
    <body>
    <h3>Temp/Pressure for Last Hour</h3>
    <?php
      date_default_timezone_set('Europe/London');
      $now = new DateTime();
      $endTime = $now->format("Y-m-d H:i:s");
      $now->modify("-1 hour");
      $startTime = $now->format("Y-m-d H:i:s");
      echo "<h4>From ".$startTime." to ".$endTime."</h4>";
    ?>
    <table>
    <tr><th>Date</th><th>Temp</th><th>Pressure</th></tr>
    <?php
      $file = '/home/pi/bmp180/sensordata.db';
      $db = new SQLite3($file);
      $query = "select date_time, temp, pressure from bmp_data where date_time between ? and ?;";
      $stmt = $db->prepare($query);
      $stmt->bindValue(1, $startTime, SQLITE3_TEXT);
      $stmt->bindValue(2, $endTime, SQLITE3_TEXT);
      $result_set = $stmt->execute();
      while ($row = $result_set->fetchArray())
      {
        echo "<tr><td>".$row['date_time']."</td><td>".$row['temp']."</td><td>".$row['pressure']."</td></tr>\n";
      }
    ?>
    </table>
    </body>
    </html>
    <?php $db->close(); ?>
