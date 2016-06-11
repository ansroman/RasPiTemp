    #!/usr/bin/env python
    import sqlite3 as sql
    import time
    import cgi
    import cgitb;
    import datetime
    cgitb.enable()  # for troubleshooting

    sensorData = sql.connect('/home/pi/bmp180/sensordata.db')
    bmp_data = sensorData.cursor()

    endTime = datetime.datetime.now()
    sqlEnd = endTime.strftime('%Y-%m-%d %H:%M:59')
    startTime = datetime.datetime.now() - datetime.timedelta(minutes=60)
    sqlStart = startTime.strftime('%Y-%m-%d %H:%M:00')

    print "Content-type: text/html"
    print

    print """
    <html>
    <head><title>Current Temperature & Pressure</title></head>
    <body>
    <h3>Temp/Pressure for Last Hour</h3>
    <h4>From %s to %s</h4>
    <table>
    """ % (cgi.escape(sqlStart), cgi.escape(sqlEnd),)

    print """
    <tr><th>Date</th><th>Temp</th><th>Pressure</th></tr>
    """

    bmp_data.execute("select date_time, temp, pressure from bmp_data where date_time between ? and ?",(sqlStart, sqlEnd))
    while True:
        row = bmp_data.fetchone()
        if row == None:
            break


        print """
    <tr><td>%s</td><td>%f</td><td>%f</td></tr>
    """ % (row[0], row[1], row[2],)

    print """
    </table>
    </body>
    </html>
    """
