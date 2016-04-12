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
            <li><a href="ad-admin.php">Admin Dashboard</a></li>
            <li><a href="ad-marketing-dashboard-drivers.php">Marketing Dashboard - Drivers</a></li>
			      <li class="active"><a href="ad-marketing-dashboard-riders.php">Marketing Dashboard - Riders<span class="sr-only">(current)</span></a></li>
			
          </ul>
        </div>
	</div>
</div>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<h2 class="sub-header">Targeted riders</h2>
<div class="table-responsive">
<table class="table table-striped">

<tr><td>
<form>
        Min rides: <input type="text" name="min_rides" id="min_rides">
        Max rides: <input type="text" name="max_rides" id="max_rides">
		<br><br>
        Min spend: <input type="text" name="min_spend" id="min_spend">
		Max spend: <input type="text" name="max_spend" id="max_spend">
        <input type="submit" name="formSubmit" value="Search" >
</form>
<?php

if(!isset($_GET['formSubmit'])) 
{	
    $query0 = "SELECT u.id, u.first_name, u.last_name, u.email, 
	COUNT(u.id) AS no_of_rides_taken, SUM(r.cost) AS total_spent 
	FROM users u, ride r, proposal p 
	WHERE p.rideid=r.rideid AND u.id=p.riderid 
	GROUP BY u.id, u.first_name, u.last_name, u.email 
	HAVING (COUNT(u.id)>=0 AND COUNT(u.id)<=10) OR SUM(r.cost)>10 
	ORDER BY SUM(r.cost) DESC";
	$result0 = pg_query($query0);
echo "<table border=\"1\" >
    <col width=\"80\">
    <col width=\"120\">
    <col width=\"120\">
    <col width=\"200\">
    <col width=\"80\">
    <col width=\"80\">
    <thead>
	<tr>
    <th>ID</th>
    <th>First name</th>
    <th>Last name</th>
    <th>Email</th>
    <th>Number of rides taken</th>
    <th>Total spent</th>
    </tr>
	</thead>";

    while ($row = pg_fetch_array($result0)){
      echo "<tbody><tr>";
      echo "<td>{$row['id']}</td>";
      echo "<td>" . $row['first_name'] . "</td>";
      echo "<td>" . $row['last_name'] . "</td>";
      echo "<td>" . $row['email'] . "</td>";
      echo "<td>" . $row['no_of_rides_taken'] . "</td>";
	  echo "<td>" . $row['total_spent'] . "</td>";
      echo "</tr></tbody>";
    }
    echo "</table>";
    
    pg_free_result($result0);
}
if(isset($_GET['formSubmit'])) 
{
    $query = "SELECT u.id, u.first_name, u.last_name, u.email, 
	COUNT(u.id) AS no_of_rides_taken, SUM(r.cost) AS total_spent 
	FROM users u, ride r, proposal p 
	WHERE p.rideid=r.rideid AND u.id=p.riderid 
	GROUP BY u.id, u.first_name, u.last_name, u.email 
	HAVING (COUNT(u.id) >= ".$_GET['min_rides']." AND COUNT(u.id) <= ".$_GET['max_rides'].") 
	OR (SUM(r.cost) >= ".$_GET['min_spend']." AND SUM(r.cost) <= ".$_GET['max_spend'].")  
	ORDER BY SUM(r.cost) DESC";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    echo "<table border=\"1\" >
    <col width=\"80\">
    <col width=\"120\">
    <col width=\"120\">
    <col width=\"200\">
    <col width=\"80\">
    <col width=\"80\">
    <thead>
	<tr>
    <th>ID</th>
    <th>First name</th>
    <th>Last name</th>
    <th>Email</th>
    <th>Number of rides taken</th>
    <th>Total spent</th>
    </tr>
	</thead>";

    while ($row = pg_fetch_array($result)){
      echo "<tbody><tr>";
      echo "<td>{$row['id']}</td>";
      echo "<td>" . $row['first_name'] . "</td>";
      echo "<td>" . $row['last_name'] . "</td>";
      echo "<td>" . $row['email'] . "</td>";
      echo "<td>" . $row['no_of_rides_taken'] . "</td>";
	  echo "<td>" . $row['total_spent'] . "</td>";
      echo "</tr></tbody>";
    }
    echo "</table>";
    
    pg_free_result($result);
}
?>

</td> </tr>
</div>
</div>
</table>

</body>
</html>
