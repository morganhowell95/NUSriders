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
			<li class="active"><a href="ad-riders-list.php">Riders<span class="sr-only">(current)</span></a></li>
			<li><a href="add-user.php">Add user</a></li>
			<li><a href="update-user.php">Update user</a></li>
			<li><a href="ad-admin.php">Admin Dashboards</a></li>	
      <li><a href="ad-marketing-dashboard-drivers.php">Marketing Dashboard - Drivers</a></li>
      <li><a href="ad-marketing-dashboard-riders.php">Marketing Dashboard - Riders</a></li>
          </ul>
        </div>
	</div>
</div>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<h2 class="sub-header">Riders</h2>
<div class="table-responsive">
<table class="table table-striped">

<tr><td>
<?php

if(!isset($_GET['formSubmit'])) 
{
$query0 = "SELECT r.rideid, r.routeid, r.startdt, r.capacity, r.cost FROM ride r";
$result0 = pg_query($query0);
    echo "<table border=\"1\" >
    <col width=\"80\">
    <col width=\"80\">
    <col width=\"120\">
    <col width=\"80\">
    <col width=\"80\">
    <col width=\"80\">
    <col width=\"80\">
    <thead>
  <tr>
    <th>Ride ID</th>
    <th>Route ID</th>
    <th>Start time</th>
    <th>Capacity</th>
    <th>Cost</th>
    <th>Edit</th>
    <th>Delete</th>
    </tr>
  </thead>";

    while ($row = pg_fetch_array($result0)){
      echo "<tbody><tr>";
      echo "<td>" . $row['rideid'] . "</td>";
      echo "<td>" . $row['routeid'] . "</td>";
      echo "<td>" . $row['startdt'] . "</td>";
      echo "<td>" . $row['capacity'] . "</td>";
      echo "<td>" . $row['cost'] . "</td>";
      echo "<td><a href='update-ride.php?update={$row['rideid']}'> Edit </a></td>";
      echo "<td><a href='delete-ride.php?delete={$row['rideid']}'> Delete </a></td>";
      echo "</tr></tbody>";
    }
    echo "</table>";
    
    pg_free_result($result0);
}

?>

</td> </tr>
</div>
</div>

</table>

</body>
</html>
