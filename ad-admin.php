<html>

    <?php
        include_once 'php/connect.php';
    ?>

<head>
<title>NUSriders</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="assets/css/dashboard/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/dashboard.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">NUSriders</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
        </div>
      </div>
    </nav>

 <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
		 <ul class="nav nav-sidebar">
		 </ul>
          <ul class="nav nav-sidebar">
			      <li><a href="ad-drivers-list.php">Drivers</a></li>
            <li><a href="ad-riders-list.php">Riders</a></li>
            <li><a href="add-user.php">Add user</a></li>
            <li><a href="update-user.php">Update user</a></li>
            <li class="active"><a href="ad-admin.php">Admin Dashboard<span class="sr-only">(current)</span></a></li>
            <li><a href="ad-marketing-dashboard-drivers.php">Marketing Dashboard - Drivers</a></li>
            <li><a href="ad-marketing-dashboard-riders.php">Marketing Dashboard - Riders</a></li>
          </ul>
        </div>
	</div>
</div>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<h2 class="sub-header">Admin Dashboard</h2>
<div class="table-responsive">
<table class="table table-striped">

<tr><td>


<?php

 $query1 = "SELECT count(*) from users u";
 $query2 = "SELECT COUNT(*) FROM users u WHERE EXISTS(SELECT * FROM route WHERE driverid=u.id)";
 $query3 = "SELECT COUNT(*) FROM users u where NOT EXISTS(SELECT * FROM route WHERE driverid=u.id)";
 $query4 = "SELECT count(*) from ride";
 $query5 = "SELECT MAX(cost) from ride where startDT>=Now() - interval '1 month' and startDT<=Now()";
 $query6 = "SELECT MIN(cost) from ride where startDT>=Now() - interval '1 month' and startDT<=Now();";
 $query7 = "SELECT Round(AVG(capacity),1) FROM ride ";
 $query8 = "Select count(u.id) from users u 
Having count(*) >= ALL (
Select count(r1.driverID) 
From users u2, route r1 , ride r2, proposal p where u2.id = r1.driverID and r1.routeID = r2.routeID and p.rideID = r2.rideID 
group by u2.id)";

/*
 $query9 = "Select MAX(cost) from ride where startDT>= Now()-interval '1 month' and startDT<=Now() ";
 $query10 = "Select MIN(cost) from ride where startDT>= Now()-interval '1 month' and startDT<=Now() ";
 $query11 = "SELECT Round(AVG(capacity),0) FROM ride ";
 */
 
 $result1 = pg_query($query1) or die('Query failed: ' . pg_last_error());
 $result2 = pg_query($query2) or die('Query failed: ' . pg_last_error());
 $result3 = pg_query($query3) or die('Query failed: ' . pg_last_error());
 $result4 = pg_query($query4) or die('Query failed: ' . pg_last_error());
 $result5 = pg_query($query5) or die('Query failed: ' . pg_last_error());
 $result6 = pg_query($query6) or die('Query failed: ' . pg_last_error());
 $result7 = pg_query($query7) or die('Query failed: ' . pg_last_error());
 $result8 = pg_query($query8) or die('Query failed: ' . pg_last_error());
 /*
 $result9 = pg_query($query9) or die('Query failed: ' . pg_last_error());
 $result10 = pg_query($query10) or die('Query failed: ' . pg_last_error());
 $result11 = pg_query($query11) or die('Query failed: ' . pg_last_error());
*/
 
  
 $row1 = pg_fetch_row($result1);
 $row2 = pg_fetch_row($result2);
 $row3 = pg_fetch_row($result3);
 $row4 = pg_fetch_row($result4);
 $row5 = pg_fetch_row($result5);
 $row6 = pg_fetch_row($result6);
 $row7 = pg_fetch_row($result7);
 $row8 = pg_fetch_row($result8);
 /*
 $row9 = pg_fetch_row($result9);
 $row10 = pg_fetch_row($result10);
 $row11 = pg_fetch_row($result11);
*/
 
 
?>
<p>Number of users: <?php echo $row1[0] ?>.</p>
<p>Number of drivers: <?php echo $row2[0] ?>.</p>
<p>Number of riders: <?php echo $row3[0] ?>.</p>
<p>Total rides: <?php echo $row4[0] ?>.</p>
<p>Biggest transaction within 1 month is <?php echo $row5[0] ?>.</p>
<p>Smallest transaction within 1 month is <?php echo $row6[0] ?>.</p>
<p>Average capacity of rides: <?php echo $row7[0] ?>.</p>

<p>Number of drivers with least drives: <?php echo $row8[0] ?>.</p>


<p><a href="ad-users-stats.php">Users' statistics</a></p>
<p><a href="ad-capacity-stats.php">Capacity statistics</a></p>

</td> </tr>
</div>
</div>
</table>

</body>
</html>
